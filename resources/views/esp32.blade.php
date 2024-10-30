<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESP32 Control</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        h2 {
            color: #555;
        }

        .led-control {
            margin-top: 20px;
        }

        .led-control label {
            font-size: 16px;
            margin-right: 10px;
        }

        .led-control input[type="checkbox"] {
            transform: scale(1.5);
            margin-right: 10px;
        }

        .led-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
    </style>

    <script>
        // Add your JavaScript here
    </script>
</head>
<body>
    <div class="container">
        <h1>ESP32 Sensor Data</h1>
        <button onclick="GetDataById('esp32_01')">Get Data</button>
        
        <h2>Temperature: <span id="esp32_01_Temperature">-</span></h2>
        <h2>Humidity: <span id="esp32_01_Humidity">-</span></h2>

        <h3>Control LEDs</h3>
        <div class="led-control">
            <div class="led-group">
                <label>LED 1</label>
                <input type="checkbox" id="ESP32_01_TogLED_01" onclick="toggleLED('ESP32_01_TogLED_01')" />
            </div>
            <div class="led-group">
                <label>LED 2</label>
                <input type="checkbox" id="ESP32_01_TogLED_02" onclick="toggleLED('ESP32_01_TogLED_02')" />
            </div>
            <div class="led-group">
                <label>LED 3</label>
                <input type="checkbox" id="ESP32_01_TogLED_03" onclick="toggleLED('ESP32_01_TogLED_03')" />
            </div>
            <div class="led-group">
                <label>LED 4</label>
                <input type="checkbox" id="ESP32_01_TogLED_04" onclick="toggleLED('ESP32_01_TogLED_04')" />
            </div>
        </div>
    </div>
</body>
</html>
