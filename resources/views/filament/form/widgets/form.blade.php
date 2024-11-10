<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 mb-12">
        @php
            $user = Auth::user();
            $totalJobs = 0;

            // Ambil jumlah data berdasarkan pengguna yang sedang login
            $countJobs = \App\Models\ComelateEmployee::where('created_by', $user->id)->count();
            $countPengajuan = \App\Models\PengajuanFasilitas::where('created_by', $user->id)->count();
        @endphp

        <!-- Card 1: Comelate Employee -->
        @if ($user->isAdminHr() || $user->isSuperAdmin() || $user->isSecurity())
            @php $totalJobs++; @endphp
            <x-filament::card class="max-w-sm">
                <div class="flex flex-col items-center">
                    <div class="relative mb-4">
                        <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/comelate.png') }}" alt="Comelate Employee" />
                    </div>
                    <div class="space-y-2 text-center">
                        <h5 class="text-lg font-bold">Comelate Employee</h5>
                        <x-filament::button 
                            badge-color="danger"
                            color="success"
                            tag="a" 
                            href="/form/comelate-employees"
                        >
                            <x-slot name="badge">
                                {{ $countJobs }} <!-- Badge berdasarkan jumlah dari created_by -->
                            </x-slot>
                            My Transaction
                        </x-filament::button>
                        <x-filament::button 
                            tag="a" 
                            href="/form/comelate-employees/create" 
                            class="mt-4"
                        >
                            Create Form
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::card>
        @endif

        <!-- Card 2: Facility Submission -->
        @if ($user->isUser() || $user->isSuperAdmin() || $user->isUserWh() || $user->isAdminGa() || $user->isAdminWh() || $user->isSuperAdminWh())
        @php $totalJobs++; @endphp
        <x-filament::card class="max-w-sm">
            <div class="flex flex-col items-center">
                <div class="relative mb-4">
                    <img class="w-full h-32 object-cover aspect-square" src="{{ url('images/pengajuan-fasilitas.png') }}" alt="Facility Submission" />
                </div>
                <div class="space-y-2 text-center">
                    <h5 class="text-lg font-bold">Facility Submission</h5>
                    <x-filament::button 
                        badge-color="danger"
                        color="success"
                        tag="a" 
                        href="/form/pengajuan-fasilitas"
                    >
                        <x-slot name="badge">
                            {{ $countPengajuan }} <!-- Badge berdasarkan jumlah dari created_by -->
                        </x-slot>
                        My Transaction
                    </x-filament::button>
                    <x-filament::button 
                        tag="a" 
                        href="/form/pengajuan-fasilitas/create" 
                        class="mt-4"
                    >
                        Create Form
                    </x-filament::button>
                </div>
            </div>
        </x-filament::card>
        @endif

        @php
            session(['total_jobs' => $totalJobs]);
        @endphp
    </div>
</x-filament-widgets::widget>
