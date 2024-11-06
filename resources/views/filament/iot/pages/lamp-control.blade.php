<x-filament-panels::page>
    <div id="relay-controls" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4">
        @foreach (range(1, 4) as $relayNumber)
            <x-filament::card class="text-center p-4 mb-2">
                <div class="flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-5">Lamp {{ $relayNumber }}</h3>
                    <div class="flex justify-center mb-5">
                        <x-filament::button 
                            color="primary" 
                            class="px-4 py-3 text-lg"
                            id="toggle-{{ $relayNumber }}"
                            onclick="toggleRelayStatus({{ $relayNumber }})">
                            Switch
                        </x-filament::button>
                    </div>
                    <p id="status-{{ $relayNumber }}">
                        <span id="badge-{{ $relayNumber }}" class="badge">Status: Unknown</span>
                    </p>
                </div>
            </x-filament::card>
        @endforeach
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleRelayStatus(relayNumber) {
            const badge = $(`#badge-${relayNumber}`);
            const currentStatus = badge.text().includes('On') ? 1 : 0;
            const newStatus = currentStatus ? 0 : 1;

            $.ajax({
                url: `/api/relay/update/${relayNumber}`,
                type: 'POST',
                data: {
                    status: newStatus
                },
                // success: function(response) {
                //     alert(`Relay ${relayNumber} turned ${newStatus ? 'On' : 'Off'}`);
                //     updateBadge(relayNumber, newStatus);
                // },
                // error: function(xhr, status, error) {
                //     alert('Failed to update relay status.');
                //     console.log(xhr.responseText);
                // }
            });
        }

        function updateBadge(relayNumber, status) {
            const badge = $(`#badge-${relayNumber}`);
            if (status) {
                badge.text('Status: On').removeClass('bg-red-500').addClass('bg-green-500');
            } else {
                badge.text('Status: Off').removeClass('bg-green-500').addClass('bg-red-500');
            }
        }

        function fetchRelayStatus() {
            $.get('/api/relays', function(relays) {
                relays.forEach(relay => {
                    updateBadge(relay.relay_number, relay.status);
                });
            });
        }

        function scheduleRelayControl() {
            const now = new Date();
            const utcOffset = 7; // Jakarta is UTC+7
            const jakartaTime = new Date(now.getTime() + utcOffset * 60 * 60 * 1000);
            const hours = jakartaTime.getHours();
            const minutes = jakartaTime.getMinutes();

            if (hours === 9 && minutes === 32) {
                for (let i = 1; i <= 4; i++) {
                    updateRelayStatus(i, 0);
                }
            } else if (hours === 9 && minutes === 33) {
                for (let i = 1; i <= 4; i++) {
                    updateRelayStatus(i, 1);
                }
            }
        }

        $(document).ready(function() {
            fetchRelayStatus();
            setInterval(scheduleRelayControl, 60000);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>

    <style>
        .badge {
            padding: 0.2em 0.5em;
            border-radius: 0.20rem;
            color: white;
        }
        .bg-green-500 {
            background-color: #38a169; /* Green */
        }
        .bg-red-500 {
            background-color: #e53e3e; /* Red */
        }
    </style>
</x-filament-panels::page>
