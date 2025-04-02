<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        COTIZACIÓN - {{ $quotation->identifier }}
    </title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
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

        table {
            font-size: x-small;
            width: 100%;
            border-collapse: collapse;
        }

        span {
            font-size: 13px;
            display: block;
            margin: 5px auto;
        }

        .client-data {
            border: 1px dashed gray;
            padding: 5px;
            border-radius: 10px;
        }

        .invoice-information {
            letter-spacing: 0.1rem;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        tbody tr td,
        thead tr th {
            padding: 5px;
        }

        hr {
            border: none;
            margin: 20px auto;
            border-top: 1px dashed blue;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td>
                <h1 style="color: #1d1d97;">{{ $quotation->company->trade_name }}</h1>
                <span>{{ $quotation->company->number }}</span>
                <span>{{ $quotation->company->address }}</span>
                <span>{{ $quotation->company->ubigeo }}</span>
                <span>{{ $quotation->company->phone }}</span>
                <span>{{ $quotation->company->email }}</span>
            </td>
            <td align="right" valign="top">
                <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="client-data">
                <span><b>Cliente:</b> {{ $quotation->person->name }}</span>
                <span><b>DNI/RUC:</b> {{ $quotation->person->number }}</span>
                <span><b>Dirección:</b> {{ $quotation->person->address }}</span>
                <span><b>Método de pago:</b> {{ $quotation->payment_method->description }}</span>
                <span><b>Vendedor:</b> {{ $quotation->user->name }}</span>
            </td>
            <td align="right">
                <div class="invoice-information">
                    <h1>{{ $quotation->identifier }}</h1>
                    <p><b>FE:</b> {{ $quotation->date_of_issue->format('d-m-Y') }}</p>
                    <p><b>FV:</b> {{ $quotation->date_of_due->format('d-m-Y') }}</p>
                </div>
            </td>
        </tr>
    </table>

    <br />

    <table>
        <thead style="background-color: #4541ca; color: white;">
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
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                    <td class="text-center">{{ $item->unit_type_id }}</td>
                    <td class="text-left">{{ $item->description }}</td>
                    <td class="text-right">S/ {{ number_format($item->unit_price, 2, '.', ',') }}</td>
                    <td class="text-right">{{ $item->discount }}</td>
                    <td class="text-right">S/ {{ number_format($item->total, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
        <br />
        <tfoot>
            <tr>
                <td colspan="5"></td>
                <td class="text-left">
                    <h4>OP. GRAVADA:</h4>
                </td>
                <td class="text-right">
                    <h4>S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</h4>
                </td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td class="text-left">
                    <h4>IGV 18%:</h4>
                </td>
                <td class="text-right">
                    <h4>{{ number_format($quotation->total_igv, 2, '.', ',') }}</h4>
                </td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td class="text-left">
                    <h4>TOTAL A PAGAR:</h4>
                </td>
                <td class="text-right">
                    <h4>{{ number_format($quotation->total, 2, '.', ',') }}</h4>
                </td>
            </tr>
        </tfoot>
    </table>

    <br />
    <hr />

    <table style="border: 1px dashed gray;">
        <thead style="background-color: #4541ca; color: white;">
            <tr>
                <th>Terminos y Condiciones:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Esta cotización es válida por 30 días a partir de la fecha de emisión. Después de este período, los
                    precios y condiciones están sujetos a cambios sin previo aviso.</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
