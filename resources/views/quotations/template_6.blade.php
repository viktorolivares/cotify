<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        COTIZACIÓN - {{ $quotation->identifier }}
    </title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif, Arial, Helvetica;
            font-size: 12px;
        }

        h1,
        h4,
        h5,
        h3,
        p {
            margin: 0;
            padding: 0;
        }

        hr {
            border: 1px solid gray;
        }

        table {
            width: 100%;
        }

        .table-row-border>th {
            border-left-color: white;
            border-right-color: white;
            border-bottom-color: teal;
            border-top-color: teal;
            border-width: 2px;
            border-style: solid;
            margin: 0;
            padding: 5px;
            text-align: center;
            color: teal;
        }

        td {
            padding: 5px;
        }

        .title-logo {
            width: 90%;
            height: auto;
            margin: 35px auto;
            text-align: left;
        }

        .title-logo .title {
            width: 35%;
            display: inline-block;
            vertical-align: top;
            margin: 0 2%;
        }

        .title-logo .logo {
            width: 60%;
            display: inline-block;
            text-align: right;
        }

        .info-container {
            width: 95%;
            height: auto;
            margin: 25px auto;
            text-align: center;
        }

        .info-container .company,
        .info-container .client,
        .info-container .quotation {
            display: inline-block;
            vertical-align: top;
            margin: 0 10px;
        }

        .info-container .company,
        .info-container .client {
            width: 36%;
            text-align: left;
            height: 120px;
        }

        .info-container .quotation {
            text-align: right;
            border: 1px solid teal;
            padding: 15px 20px;
            border-radius: 10px;
        }

        .items-table {
            width: 90%;
            margin: 20px auto;
        }

        .foot-info {
            width: 90%;
            margin: 45px auto;
            height: auto;
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px dashed gray;
        }

        .terms {
            width: 55%;
            text-align: left;
            padding: 15px auto;
            color: teal;
            display: inline-block;
        }

        .total-table {
            width: 44%;
            text-align: right;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="title-logo">
        <div class="title">
            <h1 style="color: teal">COTIZACIÓN</h1>
        </div>
        <div class="logo">
            <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
        </div>
    </div>
    <div class="info-container">
        <div class="company">
            <h4 style="color: teal;">{{ $quotation->company->trade_name }}</h4>
            <p>{{ $quotation->company->address }}</p>
            <p>{{ $quotation->company->ubigeo }}</p>
            <p>Telf: {{ $quotation->company->phone }}</p>
            <p>Email: {{ $quotation->company->email }}</p>
            <p>RUC: {{ $quotation->company->number }}</p>
        </div>
        <div class="client">
            <h4 style="color: teal;">CLIENTE</h4>
            <h4>{{ $quotation->person->name }}</h4>
            <p>{{ $quotation->person->address }}</p>
            <p>Telf: {{ $quotation->person->phone }}</p>
            <p>DNI/RUC: {{ $quotation->person->number }}</p>
        </div>
        <div class="quotation">
            <h2 style="color: teal;">{{ $quotation->identifier }}</h2>
            <h4>FE: {{ $quotation->date_of_issue->format('d-m-Y') }}</h4>
            <h4>FV: {{ $quotation->date_of_due->format('d-m-Y') }}</h4>
        </div>
    </div>
    <hr />
    <div class="items-table">
        <table style="border-spacing: 0;">
            <thead>
                <tr class="table-row-border">
                    <th>Item</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>P. Unit</th>
                    <th>DTO</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->items as $item)
                    <tr>
                        <td align="center">{{ $loop->iteration }}</td>
                        <td align="center">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                        <td align="center">{{ $item->unit_type_id }}</td>
                        <td align="left">{{ $item->description }}</td>
                        <td align="right">S/ {{ number_format($item->unit_price, 2, '.', ',') }}</td>
                        <td align="right">{{ $item->discount }}</td>
                        <td align="right">S/ {{ number_format($item->total, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <br />
            <tfoot style="font-size: 0.8rem; font-weight: bold; border-top: 1px dotted #b1b1b1;">
                <tr>
                    <td colspan="5"></td>
                    <td align="left">OP. GRAVADA:</td>
                    <td align="right">S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td align="left">IGV 18%:</td>
                    <td align="right">{{ number_format($quotation->total_igv, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td align="left">TOTAL A PAGAR:</td>
                    <td align="right">{{ number_format($quotation->total, 2, '.', ',') }}</ </tr>
            </tfoot>
        </table>
    </div>
    <div class="foot-info">
        <div class="terms">
            <h5>TERMINOS Y CONDICIONES</h5>
            <span>El pago vence dentro de los 30 días.</span>
        </div>
    </div>
</body>

</html>
