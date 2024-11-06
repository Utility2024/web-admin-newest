<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lamp Control</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css">
    <style>
        /* Gaya yang sudah ada */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            background-color: #f0f0f0;
        }
        .topnav {
            background-color: #0c6980;
            color: white;
            padding: 10px;
        }
        #relay-controls {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .card {
            background-color: white;
            box-shadow: 0px 0px 10px 1px rgba(140, 140, 140, .5);
            border-radius: 15px;
            padding: 20px;
            width: 200px;
            text-align: center;
        }
        .LEDColor {
            color: #183153;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .switch input {
            display: none;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #D3D3D3;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: #f7f7f7;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #00878F;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
    </style>
</head>
<body>
    <div class="topnav">
        <h1>SIIX LAMP CONTROL</h1>
    </div>

    <div id="relay-controls">
        @foreach(range(1, 4) as $relayNumber)
            <div class="card">
                <h3 class="LEDColor"><i class="fas fa-lightbulb"></i> LED {{ $relayNumber }}</h3>
                <label class="switch">
                    <input type="checkbox" id="relay-{{ $relayNumber }}" onchange="updateRelayStatus({{ $relayNumber }}, this.checked ? 1 : 0)">
                    <span class="slider"></span>
                </label>
                <p id="status-{{ $relayNumber }}">Status: OFF</p>
            </div>
        @endforeach
    </div>

    <script>
        // Inisialisasi Pusher
        const pusher = new Pusher('0fece2e4dc335c729a46', { // Ganti dengan kunci aplikasi Anda
            cluster: 'ap1' // Ganti dengan cluster aplikasi Anda
        });

        const channel = pusher.subscribe('relay-status-channel');
        channel.bind('App\\Events\\RelayStatusUpdated', function(data) {
            // Perbarui status relay berdasarkan data yang diterima
            $(`#relay-${data.relay_number}`).prop('checked', data.status);
            $(`#status-${data.relay_number}`).text(`Status: ${data.status ? 'ON' : 'OFF'}`);
        });

        function updateRelayStatus(relayNumber, status) {
            $.ajax({
                url: `/api/relay/update/${relayNumber}`,
                type: 'POST',
                data: { status: status },
                // success: function(response) {
                //     alert(`Relay ${relayNumber} diubah menjadi ${status ? 'ON' : 'OFF'}`);
                // },
                // error: function(xhr, status, error) {
                //     alert('Gagal memperbarui status relay.');
                //     console.log(xhr.responseText);
                // }
            });
        }

        // Fetch relay status from the server on page load
        function fetchRelayStatus() {
            $.ajax({
                url: '/api/relay/status', // Endpoint to fetch the relay status
                type: 'GET',
                success: function(data) {
                    data.forEach(function(relay) {
                        $(`#relay-${relay.relay_number}`).prop('checked', relay.status);
                        $(`#status-${relay.relay_number}`).text(`Status: ${relay.status ? 'ON' : 'OFF'}`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch relay status:', error);
                }
            });
        }

        $(document).ready(function() {
            fetchRelayStatus();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>
</body>
</html>
