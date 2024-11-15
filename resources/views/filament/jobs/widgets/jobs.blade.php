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
                <a href="/esd" class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/esd.png') }}" alt="ESD Portal" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Electrostatic Discharge</h5>
                        <p class="text-gray-600">Visit the ESD Portal for more information.</p>
                    </div>
                </a>
            </x-filament::card>
        @endif

        <!-- Card 2: Human Resource -->
        @if ($user->isAdminHr() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <a href="/hr" class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/ga.png') }}" alt="HR Portal" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Human Resource</h5>
                        <p class="text-gray-600">Visit the HR Portal for more information.</p>
                    </div>
                </a>
            </x-filament::card>
        @endif

        <!-- Card 3: General Affair -->
        @if ($user->isAdminGa() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <a href="/ga" class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/hr.png') }}" alt="GA Portal" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">General Affair</h5>
                        <p class="text-gray-600">Visit the GA Portal for more information.</p>
                    </div>
                </a>
            </x-filament::card>
        @endif

        <!-- Card 4: Utility and Facility -->
        @if ($user->isAdminUtility() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <a href="/utility" class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/utility.png') }}" alt="Utility Portal" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Utility and Facility</h5>
                        <p class="text-gray-600">Visit the Utility Portal for more information.</p>
                    </div>
                </a>
            </x-filament::card>
        @endif

        <!-- Card 5: Stock Control Material -->
        @if ($user->isAdminUtility() || $user->isAdminEsd() || $user->isAdminHr() || $user->isAdminGa() || $user->isSuperAdmin() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <a href="/stock" class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/stock.png') }}" alt="Stock Control Material" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Stock Control Material</h5>
                        <p class="text-gray-600">Visit the Stock Material Portal for more information.</p>
                    </div>
                </a>
            </x-filament::card>
        @endif

        @if ($user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <a href="/wh" class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/wh.png') }}" alt="Digital Control Tray WH" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Digital Control Tray WH</h5>
                        <p class="text-gray-600">Visit the Stock Tray Control For Warehouse for more information.</p>
                    </div>
                </a>
            </x-filament::card>
        @endif

        @if ($user->isSuperAdmin() || $user->isAdminWip() || $user->isUserWip())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <a href="/production" class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/wip.png') }}" alt="Digital Control Tray WH" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">WIP Transfer Project</h5>
                        <p class="text-gray-600">Visit the WIP Transfer Project  For Production for more information.</p>
                    </div>
                </a>
            </x-filament::card>
        @endif

        @php
            // Simpan total jobs ke dalam sesi
            session(['total_jobs' => $totalJobs]);
        @endphp
    </div>
</x-filament-widgets::widget>
