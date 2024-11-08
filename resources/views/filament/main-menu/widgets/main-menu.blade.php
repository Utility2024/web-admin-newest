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
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh() || $user->isAdminWip() || $user->isUserWip())
            @php $totalJobs++; @endphp
            <a href="/jobs" class="flex flex-col items-center">
                <x-filament::card class="h-full flex flex-col">
                    <div class="flex flex-col items-center flex-grow">
                        <div class="relative mb-4">
                            <img class="w-full h-32 object-cover" src="{{ url('images/jobs.png') }}" alt="Jobs Access" />
                        </div>
                        <div class="space-y-2 text-center flex-grow">
                            <h5 class="text-lg font-bold">Job Access</h5>
                            <p class="text-gray-600">Please explore your job access for further information.</p>
                        </div>
                    </div>
                </x-filament::card>
            </a>
        @endif

        <!-- Card 2: Form Application -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isSecurity() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh() || $user->isAdminWip() || $user->isUserWip())
            @php $totalJobs++; @endphp
            <a href="/form" class="flex flex-col items-center">
                <x-filament::card class="h-full flex flex-col">
                    <div class="flex flex-col items-center flex-grow">
                        <div class="relative mb-4">
                            <img class="w-full h-32 object-cover" src="{{ url('images/form.png') }}" alt="Form Application" />
                        </div>
                        <div class="space-y-2 text-center flex-grow">
                            <h5 class="text-lg font-bold">Form Application</h5>
                            <p class="text-gray-600">Please create and select the form you need here</p>
                        </div>
                    </div>
                </x-filament::card>
            </a>
        @endif

        <!-- Card 3: Measurement Data ESD -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh() || $user->isAdminWip() || $user->isUserWip())
            @php $totalJobs++; @endphp
            <a href="https://portal.siix-ems.co.id/scanner" class="flex flex-col items-center">
                <x-filament::card class="h-full flex flex-col">
                    <div class="flex flex-col items-center flex-grow">
                        <div class="relative mb-4">
                            <img class="w-full h-32 object-cover" src="{{ url('images/scan.png') }}" alt="Measurement Data ESD" />
                        </div>
                        <div class="space-y-2 text-center flex-grow">
                            <h5 class="text-lg font-bold">Measurement Data ESD</h5>
                            <p class="text-gray-600">Search and scan the QR-Code to find the measurement data</p>
                        </div>
                    </div>
                </x-filament::card>
            </a>
        @endif

        <!-- Card 4: Ticketing Support -->
        @if ($user->isAdminEsd() || $user->isSuperAdmin() || $user->isUser() || $user->isAdminHr() || $user->isAdminGa() || $user->isAdminUtility() || $user->isManagerAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh() || $user->isAdminWip() || $user->isUserWip())
            @php $totalJobs++; @endphp
            <a href="/ticket" class="flex flex-col items-center">
                <x-filament::card class="h-full flex flex-col">
                    <div class="flex flex-col items-center flex-grow">
                        <div class="relative mb-4">
                            <img class="w-full h-32 object-cover" src="{{ url('images/ticket.png') }}" alt="Ticketing Support" />
                        </div>
                        <div class="space-y-2 text-center flex-grow">
                            <h5 class="text-lg font-bold">Ticketing Support</h5>
                            <p class="text-gray-600">Create Ticket for a Problem or Request based on its Section</p>
                        </div>
                    </div>
                </x-filament::card>
            </a>
        @endif

        <!-- Card 5: IOT Smart Office -->
        @if ($user->isSuperAdmin() || $user->isAdminUtility() || $user->isManagerAdmin())
            @php $totalJobs++; @endphp
            <a href="/iot" class="flex flex-col items-center">
                <x-filament::card class="h-full flex flex-col">
                    <div class="flex flex-col items-center flex-grow">
                        <div class="relative mb-4">
                            <img class="w-full h-32 object-cover" src="{{ url('images/iot.png') }}" alt="IOT Smart Office" />
                        </div>
                        <div class="space-y-2 text-center flex-grow">
                            <h5 class="text-lg font-bold">IOT Smart Office</h5>
                            <p class="text-gray-600">Integrating technology to create a more efficient and productive workspace.</p>
                        </div>
                    </div>
                </x-filament::card>
            </a>
        @endif

        @php
            // Simpan total jobs ke dalam sesi
            session(['total_jobs' => $totalJobs]);
        @endphp
    </div>
</x-filament-widgets::widget>
