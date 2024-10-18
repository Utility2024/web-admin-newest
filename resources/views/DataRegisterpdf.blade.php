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
            display: flex;
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            height: 100vh; /* Full viewport height */
        }
        .content {
            width: 100%; /* Full width of the container */
            max-width: 18cm; /* Max width for the table */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px; /* Font size */
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 6px; /* Padding */
            text-align: center; /* Center text */
            vertical-align: middle; /* Center vertically */
        }
        th {
            background-color: #f2f2f2; /* Header background color */
        }
        tr:nth-child(even) {
            background-color: #ffffff; /* Alternate row color */
        }
        .header-row td {
            font-weight: bold; /* Bold font for header */
            background-color: #f2f2f2; /* Header background color */
        }
        .qr-code img {
            display: block;
            margin: 0 auto; /* Center image */
        }
    </style>
</head>
<body>
    <div class="content">
        <table>
            <tbody>
                @foreach(array_chunk($records->toArray(), 3) as $chunk)
                    <tr>
                        @foreach($chunk as $record)
                            <td>{{ $record['register_no'] }}</td> <!-- Use array syntax -->
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
