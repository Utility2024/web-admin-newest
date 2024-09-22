<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WD Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 100px;
            padding-bottom: 60px;
        }

        .content {
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            width: 100%;
        }

        .header img {
            width: 50px;
        }

        .header-title {
            text-align: center;
            flex-grow: 1;
            margin: 0 20px;
        }

        .header-title h1 {
            margin: 0;
            font-size: 18px;
        }

        .header-title h2 {
            margin: 5px 0 0;
            font-size: 16px;
        }

        .info {
            font-size: 12px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: left;
            font-size: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
        }

        header {
            position: fixed;
            top: -20px;
            left: 0px;
            right: 0px;
            height: 100px;
            text-align: center;
            line-height: 35px;
            margin-bottom: 120px;
        }

        @page {
            margin: 10mm 10mm 20mm 10mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100px;
                background: white;
                border-bottom: 1px solid #ddd;
                z-index: 1000;
            }

            .content {
                margin-top: 120px;
                /* Same as header height */
                padding-bottom: 50px;
                /* Space for footer */
            }

            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                border-top: 1px solid #ddd;
                padding: 10px;
                box-sizing: border-box;
                font-size: 10px;
                text-align: left;
            }

            @page {
                margin: 20mm;
                /* Adjust page margins if needed */
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none;"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/esd.png'))) }}" style="width: 60px;" alt="ESD Logo"></td>
                <td style="border: none;">
                    <div class="header-title">
                        <h1>MEASUREMENT REPORT</h1>
                        <h2>ESD IONIZER</h2>
                    </div>
                </td>
                <td style="border: none;"><img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo_siix.png'))) }}" style="width: 60px;" alt="SIIX Logo"></td>
            </tr>
        </table>
    </header>
    <table>
        <tbody>
            <tr>
                <th>Register NO</th>
                <th>:</th>
                <th>{{$detail->register_no}}</th>
            </tr>
            <tr>
                <th>Area</th>
                <th>:</th>
                <th>{{$detail->area}}</th>
            </tr>
            <tr>
                <th>Location</th>
                <th>:</th>
                <th>{{$detail->location}}</th>
            </tr>
        </tbody>
    </table>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Area</th>
                <th>Location</th>
                <th>PM 1</th>
                <th>PM 2</th>
                <th>PM 3</th>
                <th>C1</th>
                <th>C1 Judgement</th>
                <th>C2</th>
                <th>C2 Judgement</th>
                <th>C3</th>
                <th>C3 Judgement</th>
                <th>Remark</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$d->area}}</td>
                <td>{{$d->location}}</td>
                <td>{{$d->pm_1}}</td>
                <td>{{$d->pm_2}}</td>
                <td>{{$d->pm_3}}</td>
                <td>{{$d->c1}}</td>
                <td>{{$d->judgement_c1}}</td>
                <td>{{$d->c2}}</td>
                <td>{{$d->judgement_c2}}</td>
                <td>{{$d->c3}}</td>
                <td>{{$d->judgement_c3}}</td>
                <td>{{$d->remarks}}</td>
                <td>{{$d->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none;"><b>QR-ADM-22-K024</b></td>
                <td style="border: none;">
                    <b>{{ date('d/m/Y H:i') }}</b>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>