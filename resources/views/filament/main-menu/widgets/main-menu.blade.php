<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mb-12">
        @php
            $user = Auth::user();
            $totalJobs = 0; // Variabel untuk menghitung jumlah total card yang ditampilkan
            $assignedTicketsCount = App\Models\Ticket::where('assigned_role', $user->role)
                ->where('status', 'Open') // Hanya menghitung tiket dengan status "Open"
                ->count();
        @endphp
        
        <!-- Card 2: Human Resource -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/jobs.png') }}" alt="HR Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Jobs Access</h5>
                    <p class="text-gray-600">
                        Explore Your Job Access for more
                    </p>
                    <x-filament::button 
                        badge-color="warning"
                        tag="a" 
                        href="http://portal.siix-ems.co.id/jobs" 
                        class="mt-4"
                    >
                        More Info
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 1: Electrostatic Discharge -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/ticket.png') }}" alt="ESD Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Ticketing Support</h5>
                    <p class="text-gray-600">
                        Ticket For Problem (UTILITY, ESD, HR&GA)
                    </p>
                    <x-filament::button 
                        badge-color="warning"
                        tag="a" 
                        href="http://portal.siix-ems.co.id/ticket" 
                        class="mt-4"
                    >
                        <x-slot name="badge">
                            {{ $assignedTicketsCount }} <!-- Menampilkan jumlah tiket "Open" yang ditugaskan -->
                        </x-slot>
                        More Info
                    </x-filament::button>
                    @if (auth()->user()->isUser())
                        <x-filament::button 
                            color="success"
                            tag="a" 
                            href="http://portal.siix-ems.co.id/ticket/tickets/create" 
                            class="mt-4"
                        >
                            Create Ticket
                        </x-filament::button>
                    @endif
                </div>
            </x-filament::card>
        @endif
        
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isSecurity() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/form.png') }}" alt="HR Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Form Application</h5>
                    <p class="text-gray-600">
                        Please create the form you need here
                    </p>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/form" 
                        class="mt-4"
                    >
                        More Info
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/scan.png') }}" alt="HR Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Measurement Data ESD</h5>
                    <p class="text-gray-600">
                        Search and scan the QR-Code and find the measurement data
                    </p>
                    <x-filament::button 
                        tag="a" 
                        href="https://portal.siix-ems.co.id/scanner" 
                        class="mt-4"
                    >
                        More Info
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        @php
            // Simpan total jobs ke dalam sesi
            session(['total_jobs' => $totalJobs]);
        @endphp
    </div>
</x-filament-widgets::widget>
