@extends('template.template')
@section('title', 'SCAN QR CODE FOR SEARCH ESD MEASUREMENT')
@section('content')
<div class="container">

    <!-- Card for Camera Selection, QR Reader, and Manual Search -->
    <div class="card">
        <div class="card-body">
            <!-- Camera Selection -->
            <button class="btn btn-danger" type="button" onclick="window.location.href='/mainMenu';">Back To Main Menu</button>
            <hr>
            <div class="form-group">
                <label for="cameraSelection">Pilih Kamera:</label>
                <hr>
                <!-- Camera Selection Buttons -->
                <div id="cameraButtons" class="mb-3"></div>
                
                <hr>
                <!-- Manual Search -->
                <label for="manualSearch">Cari secara manual:</label>
                <div class="input-group">
                    <input type="text" id="manualSearch" class="form-control" placeholder="Masukkan kode atau keyword">
                    <div class="input-group-append">
                        <button id="manualSearchButton" class="btn btn-primary" type="button">Cari</button>
                    </div>
                </div>
                <hr>

                <!-- QR Code Reader with rounded corners -->
                <div id="reader" style="width: 100%; max-width: 600px; margin: auto; border-radius: 15px; overflow: hidden;"></div>

                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loadingOverlay" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/html5-qrcode/html5-qrcode.min.js') }}"></script>
<script>
    function showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').style.display = 'none';
    }

    function onScanSuccess(qrMessage) {
        console.log("QR Code detected: ", qrMessage);
        html5QrCode.stop().then(() => {
            console.log("Stopped scanning.");
            hideLoading();
            window.location.href = "/qr-scanner?search=" + qrMessage;
        }).catch(err => {
            console.error("Error stopping scanning: ", err);
            hideLoading();
        });
    }

    function onScanError(errorMessage) {
        console.log("Scan error: ", errorMessage);
        hideLoading();
    }

    var html5QrCode = new Html5Qrcode("reader");
    var currentDeviceId = null;

    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            const cameraButtonsContainer = document.getElementById('cameraButtons');
            
            devices.forEach((device, index) => {
                const button = document.createElement('button');
                button.className = 'btn btn-primary mr-2';
                button.textContent = device.label || `Camera ${index + 1}`;
                button.onclick = () => startScanning(device.id);
                cameraButtonsContainer.appendChild(button);
            });

            function startScanning(deviceId) {
                showLoading();
                if (currentDeviceId) {
                    html5QrCode.stop().then(() => {
                        console.log("Stopped scanning.");
                        startCamera(deviceId);
                    }).catch(err => {
                        console.error("Error stopping scanning: ", err);
                        hideLoading();
                    });
                } else {
                    startCamera(deviceId);
                }
            }

            function startCamera(deviceId) {
                html5QrCode.start(
                    deviceId, 
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    onScanSuccess,
                    onScanError
                ).then(() => {
                    currentDeviceId = deviceId;
                    console.log("Started scanning with camera ID:", deviceId);
                }).catch(err => {
                    console.error("Unable to start scanning: ", err);
                    hideLoading();
                });
            }

            // Automatically start scanning with the first camera
            startScanning(devices[0].id);

        } else {
            console.log("No cameras found.");
        }
    }).catch(err => {
        console.error("Error finding cameras: ", err);
        hideLoading();
    });

    // Manual Search functionality
    document.getElementById('manualSearchButton').addEventListener('click', function() {
        var searchQuery = document.getElementById('manualSearch').value;
        if (searchQuery) {
            window.location.href = "/qr-scanner?search=" + searchQuery;
        } else {
            alert("Please enter a search term.");
        }
    });
</script>
@endsection
