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

        table {
            font-size: x-small;
            width: 100%;
            border-collapse: collapse;
        }

        table tr > td, th{
            padding: 5px;
        }

        .gray {
            background-color: lightgray;
        }

        span {
            font-size: 12px;
            display: block;
            margin: 5px auto;
        }

        .client-data {
            border: 1px dashed gray;
            padding: 5px;
            border-radius: 10px;
        }

        .client-data-td {
            width: 60%;
        }

        .invoice-information-td {
            width: 30%;
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

        hr {
            border: 2px solid #2a9d5e;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td valign="top">
                <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
            </td>
            <td align="right">
                <h1 style="color: #2a9d5e;">Cotización: {{ $quotation->identifier }}</h1>
                <span><b>Fecha de Emisión: {{ $quotation->date_of_issue->format('d/m/Y') }}</b></span>
            </td>
        </tr>
    </table>
    <hr />
    <table>
        <tr>
            <td>
                <h2 style="color: #2a9d5e;">{{ $quotation->company->trade_name }}</h2>
                <span>{{ $quotation->company->number }}</span>
                <span>{{ $quotation->company->addressFull }}</span>
                <span>{{ $quotation->company->phone }}</span>
                <span>{{ $quotation->company->email }}</span>
            </td>
        </tr>
    </table>
    <hr />
    <table>
        <tr>
            <td>
                <span><b>Cliente:</b> {{ $quotation->person->name }}</span>
                <span><b>RUC:</b> {{ $quotation->person->number }}</span>
                <span><b>Dirección:</b> {{ $quotation->person->address }}</span>
            </td>
        </tr>
    </table>
    <br/>
    <table>
        <thead style="background-color: #2a9d5e; color: white;">
            <tr>
                <th>Vendedor</th>
                <th>Teléfono</th>
                <th>Condiciones de Pago</th>
                <th>Fecha de Vencimiento</th>
            </tr>
        </thead>
        <tbody style="background-color: #e3e3e3;">
            <tr>
                <td align="center">{{ $quotation->user->name }}</td>
                <td align="center">{{ $quotation->user->phone }}</td>
                <td align="center">{{ $quotation->payment_method->description }}</td>
                <td align="center">{{ $quotation->date_of_due->format('d-m-Y') }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <table>
        <thead style="background-color: #2a9d5e; color: white;">
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
        <tfoot style="font-size: 0.8rem; font-weight: bold">
            <tr>
                <td colspan="5"></td>
                <td class="text-left" style="background: #eae9e9;">OP. GRAVADA:</td>
                <td class="text-right" style="background: #a1eabd;">S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td class="text-left" style="background: #eae9e9;">IGV 18%:</td>
                <td class="text-right" style="background: #a1eabd;">{{ number_format($quotation->total_igv, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td class="text-left" style="background: #eae9e9;">TOTAL A PAGAR:</td>
                <td class="text-right" style="background: #a1eabd;">{{ number_format($quotation->total, 2, '.', ',') }}</td>
            </tr>
        </tfoot>
    </table>
    <br />
    <hr />
    <div>
        <h5>¡Gracias por su confianza!</h5>
    </div>
</body>

</html>
