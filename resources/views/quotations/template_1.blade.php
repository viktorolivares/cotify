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
            margin: 0 auto;
            padding: 0 auto;
            user-select: none;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 30px auto;
            padding: 10px 45px;
        }

        .info-text {
            display: block;
            font-size: 0.75rem;
            margin: 2px;
        }

        .wrapper-invoice .invoice {
            height: auto;
            background: #fff;
            padding: 5vh;
            margin-top: 5vh;
            max-width: 110vh;
            width: 100%;
            box-sizing: border-box;
        }

        .invoice-information {
            float: right;
            text-align: right;
            border: #6a6a6a 1px solid;
            border-radius: 20px;
            padding: 15px;
        }

        .invoice-information b {
            color: #0F172A;
        }

        .invoice-information p {
            color: #3f3f3f;
        }

        .invoice-logo-brand h2 {
            text-transform: uppercase;
            font-size: 2.9vh;
            color: #0F172A;
        }

        .invoice-logo-brand img {
            max-width: 200px;
            width: 100%;
            object-fit: fill;
        }

        .invoice-head {
            display: flex;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .company-info {
            text-align: left;
        }

        .company-info p {
            font-size: 1rem;
            color: gray;
        }

        .client-data p {
            font-size: 0.8rem;
            margin: 2px;
            color: #333333;
        }

        .invoice-body {
            margin-top: 8vh;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table thead tr th {
            font-size: 0.7rem;
            border: 1px solid #dcdcdc;
            text-align: left;
            padding: 0.6rem;
            background-color: #e0e0e0;
            text-transform: uppercase;
        }

        .table tbody tr td {
            font-size: 0.7rem;
            border: 1px solid #dcdcdc;
            padding: 0.5rem;
            background-color: #fff;
        }

        .flex-table {
            margin-top: 20px;
        }

        .flex-column {
            width: 100%;
            box-sizing: border-box;
        }

        .table-subtotal {
            border-collapse: collapse;
            box-sizing: border-box;
            width: 100%;
            margin-top: 2vh;
        }

        .table-subtotal tbody tr td {
            font-size: 2vh;
            border-bottom: 1px solid #dcdcdc;
            text-align: left;
            padding: 1vh;
            background-color: #fff;
        }

        .table-subtotal tbody tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-total-amount {
            margin-top: 1rem;
        }

        .invoice-total-amount p {
            font-weight: bold;
            color: #0F172A;
            text-align: right;
            font-size: 2vh;
        }

        .invoice-footer {
            margin-top: 10px;
        }

        .invoice-footer span {
            font-size: 1.7vh;
            color: gray;
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

        @media print {
            .table thead tr th {
                -webkit-print-color-adjust: exact;
                background-color: #eeeeee !important;
            }

            .copyright {
                display: none;
            }
        }
    </style>
</head>

<body>
    <section class="wrapper-invoice">
        <div class="invoice">
            <div class="invoice-information">
                <h2><b>Cotización #</b>: {{ $quotation->identifier }}</h2>
                <p><b>Fecha de emisión</b>: {{ $quotation->date_of_issue->format('d-m-Y') }}</p>
                <p><b>Fecha de Vencimiento</b>: {{ $quotation->date_of_due->format('d-m-Y') }}</p>
            </div>

            <div class="invoice-logo-brand">
                <img src="data:image/png;base64,{{ $logo }}" alt="logo">
            </div>

            <div class="invoice-head">
                {{-- Company Data --}}
                <div class="company-info">
                    <h3>{{ $quotation->company->trade_name }}</h3>
                    <span class="info-text">{{ $quotation->company->number }}</span>
                    <span class="info-text">{{ $quotation->company->address }}</span>
                    <span class="info-text">{{ $quotation->company->ubigeo }}</span>
                    <span class="info-text">{{ $quotation->company->phone }}</span>
                    <span class="info-text">{{ $quotation->company->email }}</span>
                </div>
                {{-- Client Information --}}
                <div class="client-data">
                    <p>— — — — — — — — — — — — — — — — — — — —</p>
                    <p><b>Cliente:</b> {{ $quotation->person->name }}</p>
                    <p><b>RUC:</b> {{ $quotation->person->number }}</p>
                    <p><b>Dirección:</b> {{ $quotation->person->address }}</p>
                    <p><b>Método de pago:</b> {{ $quotation->payment_method->description }}</p>
                    <p><b>Vendedor:</b> {{ $quotation->user->name }}</p>
                </div>
            </div>
            <!-- invoice body-->
            <div class="invoice-body">
                <table class="table">
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
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                                <td class="text-center">{{ $item->unit_type_id }}</td>
                                <td class="text-left">{{ $item->description }}</td>
                                <td class="text-right">S/ {{ number_format($item->unit_price, 2, '.', ',') }}</td>
                                <td class="text-right">{{ $item->discount }}</td>
                                <td class="text-right">S/ {{ number_format($item->total, 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                        <tr style="border-top: 2px solid #727272">
                            <td colspan="6" align="right">OP. GRAVADA:</td>
                            <td align="right" style="background: #dcdcdc">S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}</td>
                        </tr>
                        <tr style="border-top: 2px solid #ffffff">
                            <td colspan="6" align="right">IGV 18%: </td>
                            <td align="right" style="background: #dcdcdc">{{ number_format($quotation->total_igv, 2, '.', ',') }}</td>
                        </tr>
                        <tr style="border-top: 2px solid #ffffff">
                            <td colspan="6" align="right">TOTAL A PAGAR:</td>
                            <td align="right" style="background: #dcdcdc">{{ number_format($quotation->total, 2, '.', ',') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- invoice footer -->
            <div class="invoice-footer">
                <span class="info-text">Si usted tiene alguna pregunta sobre esta cotización, por favor, póngase en
                    contacto con nosotros</span>
                <span class="info-text">[{{ $quotation->company->trade_name }}, {{ $quotation->company->phone }},
                    {{ $quotation->company->email }}]</span>
            </div>
        </div>
    </section>
</body>

</html>
