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
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #1a26aa;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 97%;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #company {
            float: right;
            text-align: right;
            font-size: 12px
        }

        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 4px solid #32065e;
            float: left;
            font-size: 12px;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #32065e;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 0.9em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            font-size: 12px;
        }

        table th,
        table td {
            padding: 5px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: bold;
        }

        table td h3 {
            color: #32065e;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1em;
            background: #32065e;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .total {
            background: #32065e;
            color: #FFFFFF;
        }


        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #32065e;
            border-top: 1px solid #32065e;

        }

        table tfoot tr td:first-child {
            border: none;
        }


        #notices {
            margin: 10px;
            padding-left: 6px;
            border-left: 6px solid #32065e;
        }

        #notices .notice {
            font-size: 0.8em;
        }

    </style>
    <header class="clearfix">
        <div id="logo">
            <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
        </div>
        <div id="company">
            <h2 class="name">{{ $quotation->company->name }}</h2>
            <div>{{ $quotation->company->address }}</div>
            <div>{{ $quotation->company->ubigeo }}</div>
            <div>{{ $quotation->company->phone }}</div>
            <div><a href="#">{{ $quotation->company->email }}</a></div>
        </div>

    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to">Cotizado a:</div>
                <h2 class="name">{{ $quotation->person->name }}</h2>
                <h2 class="name">{{ $quotation->person->number }}</h2>
                <div class="address">{{ $quotation->person->address }}</div>
                <div class="email"><a href="#">{{ $quotation->person->email }}</a></div>
            </div>
            <div id="invoice">
                <h1># {{ $quotation->identifier }}</h1>
                <div class="date">Fecha de Emisión: {{ $quotation->date_of_issue->format('d/m/|Y') }}</div>
                <div class="date">Fecha de Vencimiento: {{ $quotation->date_of_due->format('d/m/Y') }}</div>
            </div>
        </div>
        <table border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="qty">Ctd.</th>
                    <th class="unit">Unidad</th>
                    <th>Descripción</th>
                    <th class="unit">P. Unit</th>
                    <th class="disc">Descuento</th>
                    <th class="total">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotation->items as $item)
                    <tr>
                        <td class="no">{{ $loop->iteration }}</td>
                        <td class="qty">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                        <td class="unit">{{ $item->unit_type_id }}</td>
                        <td>
                            <h3>{{ $item->name }}</h3>
                            {{ $item->description }}
                        </td>
                        <td class="unit">S/ {{ number_format($item->unit_price, 2, '.', ',') }}</td>
                        <td class="disc">{{ $item->discount }}</td>
                        <td class="total">S/ {{ number_format($item->total, 2, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="1">OP. GRAVADA:</td>
                    <td> S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="1">IGV 18%</td>
                    <td>S/ {{ number_format($quotation->total_igv, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td colspan="1">TOTAL</td>
                    <td>S/ {{ number_format($quotation->total, 2, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>
        <div id="notices">
            <div>Terminos y condiciones:</div>
            <div class="notice">
                Esta cotización es válida por 30 días a partir de la fecha de emisión. Después de este período, los
                precios y condiciones pueden estar sujetos a cambios.
            </div>
        </div>
    </main>
</body>

</html>
