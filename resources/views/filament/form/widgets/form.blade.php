<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mb-12">
        @php
            $user = Auth::user();
            $totalJobs = 0;

            // Ambil jumlah data berdasarkan pengguna yang sedang login
            $countJobs = \App\Models\ComelateEmployee::where('created_by', $user->id)->count();
        @endphp

        <!-- Card 1: Electrostatic Discharge -->
        @if ($user->isAdminHr() || $user->isSuperAdmin() || $user->isSecurity())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm"> <!-- Ukuran card diperkecil -->
                <div class="relative">
                    <img class="w-full h-48 object-contain aspect-square" src="{{ url('images/comelate.png') }}" alt="HR Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Comelate Employee</h5>
                    <x-filament::button 
                        badge-color="warning"
                        color="success"
                        tag="a" 
                        href="http://portal.siix-ems.co.id/form/comelate-employees"
                    >
                    <x-slot name="badge">
                        {{ $countJobs }} <!-- Badge berdasarkan jumlah dari created_by -->
                    </x-slot>
                        My Transaction
                    </x-filament::button>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/form/comelate-employees/create" 
                        class="mt-4"
                    >
                        Create Form
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm"> <!-- Ukuran card diperkecil -->
                <div class="relative">
                    <img class="w-full h-48 object-contain aspect-square" src="{{ url('images/pengajuan-fasilitas.png') }}" alt="GA Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Facility Submission</h5>
                    <x-filament::button 
                        badge-color="warning"
                        color="success"
                        tag="a" 
                        href="http://portal.siix-ems.co.id/form/pengajuan-fasilitas"
                    >
                    <x-slot name="badge">
                        {{ $countJobs }} <!-- Badge berdasarkan jumlah dari created_by -->
                    </x-slot>
                        My Transaction
                    </x-filament::button>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/form/pengajuan-fasilitas/create" 
                        class="mt-4"
                    >
                        Create Form
                    </x-filament::button>
                </div>
            </x-filament::card>

        @php
            session(['total_jobs' => $totalJobs]);
        @endphp
    </div>
</x-filament-widgets::widget>
