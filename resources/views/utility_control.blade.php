<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESP32 Control</title>
</head>
<body>
    <h1>ESP32 Control Panel</h1>
    <div id="status"></div>
    <button onclick="getData()">Get LED Status</button>
    <button onclick="updateData()">Update Data</button>

    <script>
        async function getData() {
            const response = await fetch('/api/getdata', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: 'esp32_01' })
            });
            const data = await response.json();
            document.getElementById('status').innerText = JSON.stringify(data);
        }

        async function updateData() {
            const response = await fetch('/api/updateDHT11data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: 'esp32_01',
                    temperature: 23.5,
                    humidity: 45,
                    status_read_sensor_dht11: 'SUCCEED',
                    led_01: 'ON',
                    led_02: 'OFF',
                    led_03: 'ON',
                    led_04: 'OFF'
                })
            });
            const result = await response.json();
            console.log(result);
        }
    </script>
</body>
</html>
