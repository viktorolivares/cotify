<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        COTIZACIÓN - {{ $quotation->identifier }}
    </title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 2px;
            padding: 2px;
        }

        .logo {
            padding: 20px 10px;
        }

        .company {
            font-size: 14px;
            width: 70%;
            text-align: left;
        }

        table {
            background-color: #fff;
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table thead tr {
            border: 1px solid #111;
            background-color: #f2f2f2;
        }

        table td {
            vertical-align: middle !important;
            text-align: center;
        }

        table th,
        table td {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .table-bordered {
            box-shadow: 0px 0px 5px 0.5px gray;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dbdbdb;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        hr {
            margin-bottom: 20px;
            border: 1px solid #19192e;
        }

        table.footer {
            font-family: Arial, Helvetica, sans-serif;
            width: 350px;
            height: 100px;
            text-align: left;
            border: 1px solid #ededed;
            float: right;
            margin-top: 20px;
        }

        table.footer td,
        table.footer th {
            padding: 3px 3px;
        }

        table.footer tbody td {
            font-size: 14px;
            font-weight: bold;
        }

        .header {
            width: 100%;
            margin: 20px auto;
            background: #ececec;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div>
        <div class="header">
            <div class="logo">
                <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
            </div>
        </div>
        <br />
        <table width="100%">
            <tr>
                <td class="company">
                    <h2>{{ $quotation->company->trade_name }}</h2>
                    <h4>{{ $quotation->company->number }}</h4>
                    <h4>{{ $quotation->company->address }}</h4>
                    <h4>{{ $quotation->company->ubigeo }}</h4>
                    <h4>{{ $quotation->company->phone }}</h4>
                    <h4>{{ $quotation->company->email }}</h4>
                </td>
                <td align="center">
                    <div style="padding: 5px; border: 1px dashed gray; border-radius: 10px;">
                        <h3>{{ $quotation->identifier }}</h3>
                        <p><b>FE:</b>{{ $quotation->date_of_issue->format('d-m-Y') }}</p>
                        <p><b>FV:</b>{{ $quotation->date_of_due->format('d-m-Y') }}</p>
                    </div>
                </td>
            </tr>
        </table>
        <br />
        <hr />
        <table width="100%">
            <tr>
                <td>
                    <div style="text-align: left">
                        <p><b>Nombre:</b> &nbsp; {{ $quotation->person->name }}</p>
                        <p><b>Dirección:</b> &nbsp; {{ $quotation->person->address }}</p>
                    </div>
                </td>
                <td>
                    <div style="text-align: left">
                        <p><b>Télefono:</b> &nbsp; {{ $quotation->person->phone }}</p>
                        <p><b>Método de Pago:</b> &nbsp; {{ $quotation->payment_method->description }}</p>
                    </div>
                </td>
            </tr>
        </table>
        <div>
            <table class="table-bordered">
                <thead>
                    <tr>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ number_format($item->quantity, 0, '.', ',') }}</td>
                            <td>{{ $item->unit_type_id }}</td>
                            <td>{{ $item->description }}</td>
                            <td align="right">S/ {{ number_format($item->unit_price, 2, '.', ',') }}</td>
                            <td align="right">{{ $item->discount }}</td>
                            <td align="right">S/ {{ number_format($item->total, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <table class="footer">
                    <tr>
                        <td>OP. GRAVADA:</td>
                        <td>S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</td>
                    </tr>
                    <tr>
                        <td>IGV 18%: </td>
                        <td>{{ number_format($quotation->total_igv, 2, '.', ',') }}</td>
                    </tr>
                    <tr style="background: #f2f2f2">
                        <td>TOTAL A PAGAR:</td>
                        <td>{{ number_format($quotation->total, 2, '.', ',') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <br />
        <hr />
        <div>
            <span>&copy; Copyright 2024 - {{ $quotation->company->name }}. Todos los derechos reservados. </span>
        </div>
    </div>
</body>

</html>
