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
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 95%;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: sans-serif, Arial, Helvetica;
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

        header {
            padding: 10px 0;
            margin-bottom: 50px;
        }

        #logo {
            text-align: center;
            margin-bottom: 30px;
        }

        #logo img {
            width: 150px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
        }

        #project {
            float: left;
            margin-right: 3%;
            margin-top: 20px;
            background: #f4f4f4;
            padding: 8px;
        }

        #project span {
            display: inline-block;
            color: #5D6975;
        }

        #company {
            display: inline-block;
            width: 45%;
            border: 1px dashed gray;
            padding: 10px;
            margin-top: 20px;
            background: #f5f5f5;
        }

        #project {
            display: inline-block;
            width: 45%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        {
        text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }


        table td {
            padding: 10px;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
            ;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1em;
        }

        hr {
            margin: 35px auto;
            border: none;
            border-top: 2px dashed #cdcdcd;
        }

        .gran-total>td {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
    <header class="clearfix">
        <div id="logo">
            <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
        </div>
        <h1>COTIZACIÓN - {{ $quotation->identifier }}</h1>
        <div class="info">
            <div id="company">
                <div>{{ $quotation->company->name }}</div>
                <div>{{ $quotation->company->address }}</div>
                <div>{{ $quotation->company->ubigeo }}</div>
                <div>{{ $quotation->company->phone }}</div>
                <div><a href="#">
                        <div>{{ $quotation->company->email }}</div>
                    </a>
                </div>
            </div>
            <div id="project">
                <div><span><b>CLIENTE:</b> &nbsp;{{ $quotation->person->name }} </span></div>
                <div><span><b>DIRECCIÓN:</b> &nbsp;{{ $quotation->person->address }}</span></div>
                <div><span><b>EMAIL:</b> &nbsp;<a href="#">{{ $quotation->person->email }}</a></span></div>
                <div><span><b>F. EMISIÓN:</b> &nbsp;{{ $quotation->date_of_issue->format('d/m/Y') }}</span></div>
                <div><span><b>F. VENCIMIENTO:</b> &nbsp;{{ $quotation->date_of_due->format('d/m/Y') }}</span></div>
            </div>
        </div>
    </header>
    <hr />
    <main>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>P. Unit</th>
                    <th>DTO.</th>
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
                <tr class="gran-total">
                    <td colspan="6" align="right">OP. GRAVADA</td>
                    <td align="right">
                        {{ number_format($quotation->subtotal, 2, '.', ',') }}
                    </td>
                </tr>
                <tr class="gran-total">
                    <td colspan="6" align="right">IGV (18%)</td>
                    <td align="right">
                        {{ number_format($quotation->total_igv, 2, '.', ',') }}
                    </td>
                </tr>
                <tr class="gran-total">
                    <td colspan="6" align="right">TOTAL</td>
                    <td align="right">
                        {{ number_format($quotation->total, 2, '.', ',') }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="notices">
            <div>TERMINOS Y CONDICIONES:</div>
            <div class="notice">El pago vence dentro de los 30 días.</div>
        </div>
    </main>

</body>

</html>
