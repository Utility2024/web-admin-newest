<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mb-12">
        @php
            $user = Auth::user();
            $totalJobs = 0; // Variabel untuk menghitung jumlah total card yang ditampilkan
            $assignedTicketsCount = App\Models\Ticket::where('assigned_role', $user->role)
                ->where('status', 'Open') // Hanya menghitung tiket dengan status "Open"
                ->count();
        @endphp
        
        <!-- Card 1: Human Resource -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh() )
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/jobs.png') }}" alt="Jobs Access" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Jobs Access</h5>
                        <p class="text-gray-600">Explore Your Job Access for more</p>
                        <x-filament::button 
                            badge-color="warning"
                            tag="a" 
                            href="/jobs" 
                            class="mt-4"
                        >
                            More Info
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::card>
        @endif
        
        <!-- Card 2: Form Application -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isSecurity() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/form.png') }}" alt="Form Application" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Form Application</h5>
                        <p class="text-gray-600">Please create the form you need here</p>
                        <x-filament::button 
                            tag="a" 
                            href="/form" 
                            class="mt-4"
                        >
                            More Info
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 3: Measurement Data ESD -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh())
            @php $totalJobs++; @endphp
            <x-filament::card style="max-width: 400px; margin: auto;">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/scan.png') }}" alt="Measurement Data ESD" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Measurement Data ESD</h5>
                        <p class="text-gray-600">Page Is Under Maintenance</p>
                        <p class="text-gray-600">Due Date : 07-10-2024</p>
                    </div>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 4: Ticketing Support -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-custom mx-auto">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/ticket.png') }}" alt="Ticketing Support" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Ticketing Support</h5>
                        <p class="text-gray-600">Coming Soon</p>
                    </div>
                </div>
            </x-filament::card>
        @endif


        <!-- Card 5: IOT Smart Office -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/iot.png') }}" alt="IOT Smart Office" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">IOT Smart Office</h5>
                        <p class="text-gray-600">Coming Soon</p>
                    </div>
                </div>
            </x-filament::card>
        @endif

        @php
            // Simpan total jobs ke dalam sesi
            session(['total_jobs' => $totalJobs]);
        @endphp
    </div>
</x-filament-widgets::widget>
