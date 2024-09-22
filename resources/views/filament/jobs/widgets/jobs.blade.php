<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mb-12">
        @php
            $user = Auth::user();
            $totalJobs = 0; // Variabel untuk menghitung jumlah total card yang ditampilkan
        @endphp

        <!-- Card 1: Electrostatic Discharge -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/esd.png') }}" alt="ESD Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Electrostatic Discharge</h5>
                    <p class="text-gray-600">
                        Visit the ESD Portal for more information.
                    </p>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/esd" 
                        class="mt-4"
                    >
                        More Info
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 2: Human Resource -->
        @if ($user->isAdminHr() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/ga.png') }}" alt="HR Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Human Resource</h5>
                    <p class="text-gray-600">
                        Visit the HR Portal for more information.
                    </p>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/hr" 
                        class="mt-4"
                    >
                        More Info
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 3: General Affair -->
        @if ($user->isAdminGa() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/hr.png') }}" alt="GA Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">General Affair</h5>
                    <p class="text-gray-600">
                        Visit the GA Portal for more information.
                    </p>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/ga" 
                        class="mt-4"
                    >
                        More Info
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 4: Utility and Facility -->
        @if ($user->isAdminUtility() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-cover aspect-square" src="{{ url('images/utility.png') }}" alt="Utility Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Utility and Facility</h5>
                    <p class="text-gray-600">
                        Visit the Utility Portal for more information.
                    </p>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/utility" 
                        class="mt-4"
                    >
                        More Info
                    </x-filament::button>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 5: Stock Control Material -->
        @if ($user->isAdminUtility() || $user->isAdminEsd() || $user->isAdminHr() || $user->isAdminGa() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="relative">
                    <img class="w-full h-48 object-contain aspect-square" src="{{ url('images/stock.png') }}" alt="HR Portal" />
                </div>
                <div class="space-y-2">
                    <h5 class="text-lg font-bold">Stock Control Material</h5>
                    <p class="text-gray-600">
                        Visit the Stock Material Portal for more information.
                    </p>
                    <x-filament::button 
                        tag="a" 
                        href="http://portal.siix-ems.co.id/stock" 
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
