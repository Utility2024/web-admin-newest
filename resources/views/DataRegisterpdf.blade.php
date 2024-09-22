<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .content {
            margin: 20px;
            width: 10cm; /* Lebar tabel 10cm */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px; /* Ukuran font lebih kecil */
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 6px; /* Padding lebih kecil */
            text-align: center; /* Teks di tengah */
            vertical-align: middle; /* Konten vertikal di tengah */
        }
        th {
            background-color: #f2f2f2; /* Warna latar belakang abu-abu muda */
        }
        tr:nth-child(even) {
            background-color: #ffffff; /* Warna latar belakang putih */
        }
        .header-row td {
            font-weight: bold; /* Font tebal untuk nama kolom */
            background-color: #f2f2f2; /* Warna latar belakang abu-abu muda */
        }
        .qr-code img {
            display: block;
            margin: 0 auto; /* Posisikan gambar di tengah */
        }
    </style>
</head>
<body>
    <div class="content">
        <table>
            <tbody>
                @foreach($records as $record)
                    <tr class="header-row">
                        <td>Register No</td>
                        <td>QR Code For Request</td>
                    </tr>
                    <tr>
                        <td>{{ $record->register_no }}</td>
                        <td class="qr-code">
                            @php
                                // Generate QR code yang berisi link Google Form
                                $qrCode = base64_encode(QrCode::format('svg')->size(50)->generate('bit.ly/request_assets'));
                            @endphp
                            <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
