<x-filament-panels::page>
    <div class="grid grid-cols-2 gap-4">
        @foreach (['led_01', 'led_02', 'led_03', 'led_04'] as $led)
            <div class="card">
                <div class="card-header">
                    <h2>{{ ucfirst(str_replace('_', ' ', $led)) }}</h2>
                </div>
                <div class="card-body">
                    <p>Status: {{ $leds->{$led} ? 'On' : 'Off' }}</p>
                    <form action="{{ route('filament.led-toggle', $led) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ $leds->{$led} ? 'btn-danger' : 'btn-success' }}">
                            Toggle
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
