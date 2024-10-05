<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worksurface</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
        }
        .content {
            margin: 20px;
            width: 6cm; /* Lebar total tabel 6 cm */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6px; /* Ukuran font lebih kecil */
            table-layout: fixed; /* Memastikan tabel mengikuti ukuran yang diatur */
        }
        td {
            border: 1px solid #dddddd;
            padding: 1px;
            text-align: center;
            height: 1cm; /* Tinggi sel 1 cm */
        }
        tr:nth-child(even) {
            background-color: #ffffff;
        }
        .qr-code {
            padding: 1px; /* Jarak QR Code dari tepi tabel */
        }
        .qr-code img {
            width: 30px; /* Ukuran QR Code yang lebih kecil */
            height: 30px;
            margin: auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="content">
        <table>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record->register_no }}</td>
                    <td>{{ $record->area }}</td>
                    <td>{{ $record->location }}</td>
                    <td class="qr-code">
                        @if($record->qrCode)
                            <img src="data:image/svg+xml;base64,{{ $record->qrCode }}" alt="QR Code" style="width: 100px; height: 100px;" />
                        @else
                            <span>No QR Code available</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
