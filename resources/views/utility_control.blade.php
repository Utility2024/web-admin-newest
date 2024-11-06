<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIX CONTROL UTILITY</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('d67bd18a316b308e7320', {
            cluster: 'ap1',
            useTLS: true
        });

        const channel = pusher.subscribe('led-channel');
        channel.bind('led-updated', function(data) {
            const relayId = `relay${data.relay_number}`;
            const relayCheckbox = document.getElementById(relayId);
            if (relayCheckbox) {
                relayCheckbox.checked = data.status == 1;
            } else {
                console.warn(`Checkbox dengan ID ${relayId} tidak ditemukan.`);
            }
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css">
    <style>
        html {
            font-family: Arial;
            display: inline-block;
            text-align: center;
        }
        /* Tambahkan gaya CSS Anda di sini, seperti pada kode asli */
        body {
            margin: 0;
        }
        /* Tambahkan gaya tambahan... */
    </style>
</head>
<body>
    <div class="topnav">
        <h3>SIIX CONTROL UTILITY</h3>
    </div>
    <br>
    <div class="content">
        <div class="cards">
            <div class="card">
                <div class="card header">
                    <h3 style="font-size: 1rem;">PENGENDALIAN LAMPU</h3>
                </div>

                @foreach(range(1, 4) as $i)
                    <h4 class="LEDColor"><i class="fas fa-lightbulb"></i> LED {{ $i }}</h4>
                    <label class="switch">
                        <input type="checkbox" id="relay{{ $i }}" onclick="GetTogBtnLEDState('relay{{ $i }}')" {{ isset($statusRelay[$i]) && $statusRelay[$i] == 1 ? 'checked' : '' }}>
                        <div class="sliderTS"></div>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <br>
    <script>
        function GetTogBtnLEDState(relayId) {
            const relayCheckbox = document.getElementById(relayId);
            const relayNumber = relayId.replace('relay', '');
            const status = relayCheckbox.checked ? 1 : 0;

            fetch('update_relay.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `relay_number=${relayNumber}&status=${status}`
            })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('Terjadi kesalahan:', error));
        }

        // Fungsi untuk kontrol relay berdasarkan waktu
        // Anda dapat menambahkan logika kontrol waktu di sini
    </script>
</body>
</html>
