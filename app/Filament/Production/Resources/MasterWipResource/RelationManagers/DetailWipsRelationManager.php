<?php

namespace App\Filament\Production\Resources\MasterWipResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\MasterWip;
use App\Models\DetailWip; // Ensure to import the DetailWip model
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;

class DetailWipsRelationManager extends RelationManager
{
    protected static string $relationship = 'detailWips';

    public function form(Form $form): Form
    {
        $masterWipsId = session('master_wips_id'); // Ambil master_wips_id dari session

        // Fetch the MasterWip instance to access lot_qty
        $masterWip = MasterWip::find($masterWipsId);

        // Calculate the current acm by summing up all qtys related to this master_wips_id
        $currentAcm = $this->calculateCurrentAcm($masterWipsId);

        // Calculate the current balance
        $currentBalance = $masterWip ? $masterWip->lot_qty - $currentAcm : 0;

        return $form
            ->schema([ 
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('master_wips_id')
                            ->label('Model')
                            ->relationship('masterWip', 'model')
                            ->required()
                            ->default($masterWipsId)
                            ->extraAttributes(['style' => 'pointer-events: none']), // master_wips_id tidak dapat diubah

                        Forms\Components\TextInput::make('qty')
                            ->label('Quantity')
                            ->required()
                            ->numeric()
                            ->live() // Enables live updates
                            ->afterStateUpdated(function ($state, callable $set) use ($currentAcm, $masterWip) {
                                $newAcm = $currentAcm + $state; // ACM = existing ACM + new qty
                                $balance = $masterWip ? $masterWip->lot_qty - $newAcm : 0; // Balance = lot_qty - newAcm

                                // Set new values for ACM, Balance, and Status
                                $set('acm', $newAcm);
                                $set('balance', $balance);
                                $set('status', $balance > 0 ? 'In Progress' : 'Finished'); // Set status based on balance
                            }),

                        Forms\Components\TextInput::make('acm')
                            ->label('ACM')
                            ->default($currentAcm) // Set default to current ACM
                            ->disabled() // Disable input
                            ->dehydrated(), // Don't include in the request

                        Forms\Components\TextInput::make('balance')
                            ->label('Balance')
                            ->default($currentBalance) // Set default to current balance
                            ->disabled() // Disable input
                            ->dehydrated(),

                        Forms\Components\TextInput::make('status')
                            ->label('Status')
                            ->default($currentBalance > 0 ? 'In Progress' : 'Finished') // Set default status
                            ->disabled() // Disable input
                            ->dehydrated(),

                        Forms\Components\TextInput::make('no_hu')
                            ->label('No HU')
                            ->required(),

                        Forms\Components\TextInput::make('remarks')
                            ->label('Remarks')
                            ->nullable(),
                    ])
            ]);
    }

    protected function calculateCurrentAcm($masterWipsId)
    {
        // Access the DetailWip model directly to sum the qtys
        return DetailWip::where('master_wips_id', $masterWipsId)
            ->sum('qty'); // Calculate total qty for the master_wips_id
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('master_wips_id')
            ->columns([
                Tables\Columns\TextColumn::make('qty')->label('Quantity'),
                Tables\Columns\TextColumn::make('acm')->label('ACM'),
                Tables\Columns\TextColumn::make('balance')->label('Balance'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'In Progress' => 'warning',
                        'Finished' => 'success',
                    }), // Add the status column
                Tables\Columns\TextColumn::make('no_hu')
                    ->label('No HU')
                    ->wrap(),
                Tables\Columns\TextColumn::make('remarks')->label('Remarks'),
                Tables\Columns\TextColumn::make('created_at')->label('Date')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('creator.name')->label('PIC')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('updater.name')->label('Updated By')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }

    public function save(array $data)
    {
        // Get the master wips ID
        $masterWipsId = $data['master_wips_id'];

        // Calculate the current ACM and balance
        $currentAcm = $this->calculateCurrentAcm($masterWipsId);
        $newQty = $data['qty'];
        $newAcm = $currentAcm + $newQty; // ACM = existing ACM + new qty
        $masterWip = MasterWip::find($masterWipsId);
        $balance = $masterWip ? $masterWip->lot_qty - $newAcm : 0; // Balance = lot_qty - newAcm

        // Add the new detail wip record with calculated acm and balance
        $data['acm'] = $newAcm;  // Include acm in the data array
        $data['balance'] = $balance; // Include balance in the data array
        $data['status'] = $balance > 0 ? 'In Progress' : 'Finished'; // Set status based on balance

        // Prevent creation if balance is zero
        if ($balance <= 0) {
            // Update MasterWip status to Finished
            $masterWip->update(['status' => 'Finished']);
            // Optionally throw a validation error
            throw new \Exception('Cannot create new Detail WIP because the balance is zero. MasterWIP status updated to Finished.');
        }

        // Proceed with saving
        parent::save($data);
    }
}
