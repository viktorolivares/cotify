<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        COTIZACIÓN - {{ $quotation->identifier }}
    </title>
</head>

<body>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 5px;
        }

        .container-logo {
            width: 86%;
            margin: 35px auto 20px;
            height: auto;
        }

        .container-logo .logo {
            width: 30%;
            border: 1px solid #1223d8;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .container-info {
            width: 90%;
            margin: 5px auto;
        }

        .container-info .company {
            width: 45%;
            height: 190px;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #dedede;
            margin: 0 2%;
            border-radius: 5px;
        }

        .container-info .client {
            width: 45%;
            height: 190px;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #dedede;
            margin: 0 2%;
            border-radius: 5px;
        }

        .info-company,
        .info-client {
            margin: 15px 10px;
            padding: 10px
        }

        .quotation {
            width: 90%;
            height: auto;
            margin: 0 auto;
        }

        .quotation .identifier {
            width: 45%;
            display: inline-block;
            vertical-align: top;
            margin: 0 2%;

        }

        .quotation .aditional-data {
            width: 45%;
            display: inline-block;
            vertical-align: top;
            margin: 0 2%;
        }

        .info-identifier,
        .info-aditional-data {
            padding: 10px
        }

        .items {
            width: 86%;
            margin: 10px auto;
        }


        table.data-table {
            border-top: 2px solid #cfcfcf;
            border-bottom: 2px solid #cfcfcf;
            background-color: #FFF;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        table.data-table td {
            padding: 2px 3px;
        }

        table.data-table th {
            padding: 5px 3px;
        }

        table.data-table tbody td {
            font-size: 12px;
            border-bottom: 2px solid #dfdfdf;
        }

        table.data-table tr:nth-child(even) {
            background: #ededed;
        }

        table.data-table thead {
            border-bottom: 2px solid #dfdfdf;
        }

        table.data-table thead th {
            font-weight: bold;
            background: #ededed;
        }

        .foot-info {
            width: 86%;
            height: auto;
            margin: 10px auto;
        }

        .summary-table,
        .terms {
            display: inline-block;
            vertical-align: top;
            margin-top: 10px;
        }

        .terms {
            width: 30%;
        }

        .summary-table {
            width: 35%;
            margin-left: 34%;
            text-align: right;

        }
    </style>

    <div class="container-logo">
        <div class="logo">
            <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
        </div>
    </div>

    <div class="container-info">
        <div class="company">
            <div class="info-company">
                <h2 style="color: #1223d8;">{{ $quotation->company->trade_name }}</h2>
                <h3><b>RUC: {{ $quotation->company->number }}<b></h3>
                <p>{{ $quotation->company->addressFull }}</p>
                <p>Telf: {{ $quotation->company->phone }}</p>
                <p>Email: {{ $quotation->company->email }}</p>
            </div>

        </div>
        <div class="client">
            <div class="info-client">
                <h2 style="color: #1223d8;">CLIENTE</h2>
                <h3>{{ $quotation->person->name }}</h3>
                <p>{{ $quotation->person->address }}</p>
                <p>Telf: {{ $quotation->person->phone }}</p>
                <p>Email: {{ $quotation->person->email }}</p>
                <p><b>DNI/RUC: {{ $quotation->person->number }}</b></p>
            </div>

        </div>
    </div>

    <div class="quotation">
        <div class="identifier">
            <div class="info-identifier">
                <h2 style="color: #1223d8;">Cotización #: {{ $quotation->identifier }}</h2>
                <h4>Fecha de Emisión: {{ $quotation->date_of_issue->format('d-m-Y') }}</h4>
            </div>

        </div>
        <div class="aditional-data">
            <div class="info-aditional-data">
                <h4>Fecha de Vencimiento: {{ $quotation->date_of_due->format('d-m-Y') }}</h4>
            </div>

        </div>
    </div>

    <div class="items">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th align="left">Descripción</th>
                    <th align="right">P. Unit</th>
                    <th align="right">DTO</th>
                    <th align="right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->items as $item)
                    <tr>
                        <td align="center">{{ $loop->iteration }}</td>
                        <td align="center">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                        <td align="center">{{ $item->unit_type_id }}</td>
                        <td align="left">
                            <h5>{{ $item->name }}</h5>
                            <p>{{ $item->description }}</p>
                        </td>
                        <td align="right">S/ {{ number_format($item->unit_price, 2, '.', ',') }}</td>
                        <td align="right">{{ $item->discount }}</td>
                        <td align="right">S/ {{ number_format($item->total, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="foot-info">
        <div class="terms">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="padding: 5px; color: #1223d8;">Terminos y condiciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>El pago vence dentro de los 30 días.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="summary-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="padding: 5px; color: #1223d8;">Resumen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="right">
                            <h4>OP. GRAVADA: &nbsp; S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <h4>IGV 18%: &nbsp; S/ {{ number_format($quotation->total_igv, 2, '.', ',') }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <h4>TOTAL A PAGAR: &nbsp; S/ {{ number_format($quotation->total, 2, '.', ',') }}</h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
