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
            user-select: none;
        }

        .info-text {
            display: block;
            font-size: 0.75rem;
            margin: 2px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 5px auto;
            padding: 35px;
        }

        @media print {
            .table thead tr th {
                -webkit-print-color-adjust: exact;
                background-color: #eeeeee !important;
            }
        }

        table.client-table {
            font-family: Arial, Helvetica, sans-serif;
            width: 350px;
            height: 150px;
            text-align: left;
            border-collapse: collapse;
            border: 1px solid #1f1f1f;
        }

        table.client-table td,
        table.client-table th {
            padding: 3px 3px;
        }

        table.client-table tbody td {
            font-size: 12px;
        }

        table.client-table thead {
            background: #1f1f1f;
            color: #fff;
        }

        table.client-table thead th {
            font-size: 12px;
            font-weight: bold;
            text-align: left;
        }

        table.client-table tfoot td {
            font-size: 14px;
        }

        table.items {
            font-family: Arial, Helvetica, sans-serif;
            border: 1px solid #1f1f1f;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }

        table.items td,
        table.items th {
            padding: 7px;
        }

        table.items tbody td {
            font-size: 12px;
        }

        table.items tr:nth-child(even) {
            background: #e1e1e1;
        }

        table.items thead {
            background: #1f1f1f;
        }

        table.items thead th {
            font-size: 12px;
            font-weight: bold;
            color: #FFFFFF;
        }

        table.footer {
            font-family: Arial, Helvetica, sans-serif;
            width: 350px;
            height: 150px;
            text-align: left;
            border-collapse: collapse;
            border: 1px solid #1f1f1f;
            float: right;
        }

        table.footer td,
        table.footer th {
            padding: 3px 3px;
        }

        table.footer tbody td {
            font-size: 14px;
            font-weight: bold;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
            </td>
            <td align="right">
                <h2 style="color: #1f1f1f;">COTIZACIÓN</h2>
            </td>
        </tr>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td style="width: 70%;">
                <h2>{{ $quotation->company->trade_name }}</h2>
                <h4>{{ $quotation->company->number }}</h4>
                <h4>{{ $quotation->company->address }}</h4>
                <h4>{{ $quotation->company->ubigeo }}</h4>
                <h4>{{ $quotation->company->phone }}</h4>
                <h4>{{ $quotation->company->email }}</h4>
            </td>
            <td align="center" style="width: 30%; border: 1px solid #1f1f1f; padding: 5px; border-radius: 10px;">
                <h3>{{ $quotation->identifier }}</h3>
                <p><b>FE:</b>{{ $quotation->date_of_issue->format('d-m-Y') }}</p>
                <p><b>FV:</b>{{ $quotation->date_of_due->format('d-m-Y') }}</p>
            </td>
        </tr>
    </table>
    <br />
    <table class="client-table">
        <thead>
            <tr>
                <th>Cliente</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Nombre:</b> &nbsp; {{ $quotation->person->name }}</td>
            </tr>
            <tr>
                <td><b>Dirección:</b> &nbsp; {{ $quotation->person->address }}</td>
            </tr>
            <tr>
                <td><b>Télefono:</b> &nbsp; {{ $quotation->person->phone }}</td>
            </tr>
            <tr>
                <td><b>Vendedor:</b> &nbsp; {{ $quotation->user->name }}</td>
            </tr>
            <tr>
                <td><b>Método de Pago:</b> &nbsp; {{ $quotation->payment_method->description }}</td>
            </tr>
        </tbody>
    </table>
    <table class="items">
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
    <br/>
    <div class="clearfix">
        <table class="footer">
            <tbody>
                <tr>
                    <td>OP. GRAVADA:</td>
                    <td align="right">S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td>IGV 18%: </td>
                    <td align="right">{{ number_format($quotation->total_igv, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td>TOTAL A PAGAR:</td>
                    <td align="right">{{ number_format($quotation->total, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="text-align: center;">
        <p>Si usted tiene alguna pregunta sobre esta cotización, por favor, póngase en
            contacto con nosotros
        </p>
        <p>[{{ $quotation->company->trade_name }}, {{ $quotation->company->phone }},
            {{ $quotation->company->email }}]
        </p>
    </div>
</body>

</html>
