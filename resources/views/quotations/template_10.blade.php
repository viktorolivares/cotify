<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
</head>

<body>
    <style>
        body {

            font-family: monospace, sans-serif;
            font-size: 11px
        }

        table {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .font-sm {
            font-size: 8px;
        }

        .font-md {
            font-size: 12px;
        }

        .font-lg {
            font-size: 14px;
        }

        .font-xl {
            font-size: 16px;
        }

        .font-bold {
            font-weight: bold;
        }

        .content {
            object-fit: contain;
        }

        .company_logo {
            max-height: 100px;
        }

        .company_logo_box {
            height: 100px;
        }

        .company_logo_ticket {
            max-width: 200px;
            max-height: 80px
        }

        .company_logo_ticket-sm {
            max-width: 100px;
            max-height: 80px
        }

        .contain {
            object-fit: cover;
        }

        .full-width {
            width: 100%;
        }

        .m-10 {
            margin: 10px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .m-20 {
            margin: 20px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .p-20 {
            padding: 20px;
        }

        .pt-20 {
            padding-top: 20px;
        }

        .pb-20 {
            padding-bottom: 20px;
        }

        .p-10 {
            padding: 10px;
        }

        .pt-10 {
            padding-top: 10px;
        }

        .pb-10 {
            padding-bottom: 10px;
        }

        .border-box {
            border: thin dashed #333;
        }

        .border-top {
            border-top: thin dashed #333;
        }

        .border-bottom {
            border-bottom: thin dashed #333;
        }

        .border-top-bottom {
            border-top: thin dashed #333;
            border-bottom: thin dashed #333;
        }

        .bg-grey {
            background-color: #F8F8F8;
        }


        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 200;
            letter-spacing: -1px;
        }

        h1 {
            font-size: 32px;
            line-height: 44px;
            font-weight: 500;
        }

        h2 {
            font-size: 24px;
            font-weight: 500;
            line-height: 42px;
        }

        h3 {
            font-size: 18px;
            font-weight: 400;
            letter-spacing: normal;
            line-height: 24px;
        }

        h4 {
            font-size: 16px;
            font-weight: 400;
            letter-spacing: normal;
            line-height: 27px;
        }

        h5 {
            font-size: 13px;
            font-weight: 300;
            letter-spacing: normal;
            line-height: 18px;
        }

        .m-0 {
            margin: 0;
        }

        .mt-0,
        .my-0 {
            margin-top: 0;
        }

        .mr-0,
        .mx-0 {
            margin-right: 0;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0;
        }

        .ml-0,
        .mx-0 {
            margin-left: 0;
        }

        .m-1 {
            margin: 0.25rem;
        }

        .mt-1,
        .my-1 {
            margin-top: 0.25rem;
        }

        .mr-1,
        .mx-1 {
            margin-right: 0.25rem;
        }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25rem;
        }

        .ml-1,
        .mx-1 {
            margin-left: 0.25rem;
        }

        .m-2 {
            margin: 0.5rem;
        }

        .mt-2,
        .my-2 {
            margin-top: 0.5rem;
        }

        .mr-2,
        .mx-2 {
            margin-right: 0.5rem;
        }

        .mb-2,
        .my-2 {
            margin-bottom: 0.5rem;
        }

        .ml-2,
        .mx-2 {
            margin-left: 0.5rem;
        }

        .m-3 {
            margin: 1rem;
        }

        .mt-3,
        .my-3 {
            margin-top: 1rem;
        }

        .mr-3,
        .mx-3 {
            margin-right: 1rem;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem;
        }

        .ml-3,
        .mx-3 {
            margin-left: 1rem;
        }

        .m-4 {
            margin: 1.5rem;
        }

        .mt-4,
        .my-4 {
            margin-top: 1.5rem;
        }

        .mr-4,
        .mx-4 {
            margin-right: 1.5rem;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem;
        }

        .ml-4,
        .mx-4 {
            margin-left: 1.5rem;
        }

        .m-5 {
            margin: 3rem;
        }

        .mt-5,
        .my-5 {
            margin-top: 3rem;
        }

        .mr-5,
        .mx-5 {
            margin-right: 3rem;
        }

        .mb-5,
        .my-5 {
            margin-bottom: 3rem;
        }

        .ml-5,
        .mx-5 {
            margin-left: 3rem;
        }

        .p-0 {
            padding: 0;
        }

        .pt-0,
        .py-0 {
            padding-top: 0;
        }

        .pr-0,
        .px-0 {
            padding-right: 0;
        }

        .pb-0,
        .py-0 {
            padding-bottom: 0;
        }

        .pl-0,
        .px-0 {
            padding-left: 0;
        }

        .p-1 {
            padding: 0.25rem;
        }

        .pt-1,
        .py-1 {
            padding-top: 0.25rem;
        }

        .pr-1,
        .px-1 {
            padding-right: 0.25rem;
        }

        .pb-1,
        .py-1 {
            padding-bottom: 0.25rem;
        }

        .pl-1,
        .px-1 {
            padding-left: 0.25rem;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .pt-2,
        .py-2 {
            padding-top: 0.5rem;
        }

        .pr-2,
        .px-2 {
            padding-right: 0.5rem;
        }

        .pb-2,
        .py-2 {
            padding-bottom: 0.5rem;
        }

        .pl-2,
        .px-2 {
            padding-left: 0.5rem;
        }

        .p-3 {
            padding: 1rem;
        }

        .pt-3,
        .py-3 {
            padding-top: 1rem;
        }

        .pr-3,
        .px-3 {
            padding-right: 1rem;
        }

        .pb-3,
        .py-3 {
            padding-bottom: 1rem;
        }

        .pl-3,
        .px-3 {
            padding-left: 1rem;
        }

        .p-4 {
            padding: 1.5rem;
        }

        .pt-4,
        .py-4 {
            padding-top: 1.5rem;
        }

        .pr-4,
        .px-4 {
            padding-right: 1.5rem;
        }

        .pb-4,
        .py-4 {
            padding-bottom: 1.5rem;
        }

        .pl-4,
        .px-4 {
            padding-left: 1.5rem;
        }

        .p-5 {
            padding: 3rem;
        }

        .pt-5,
        .py-5 {
            padding-top: 3rem;
        }

        .pr-5,
        .px-5 {
            padding-right: 3rem;
        }

        .pb-5,
        .py-5 {
            padding-bottom: 3rem;
        }

        .pl-5,
        .px-5 {
            padding-left: 3rem;
        }

        .m-n1 {
            margin: -0.25rem;
        }

        .mt-n1,
        .my-n1 {
            margin-top: -0.25rem;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -0.25rem;
        }

        .mb-n1,
        .my-n1 {
            margin-bottom: -0.25rem;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -0.25rem;
        }

        .m-n2 {
            margin: -0.5rem;
        }

        .mt-n2,
        .my-n2 {
            margin-top: -0.5rem;
        }

        .mr-n2,
        .mx-n2 {
            margin-right: -0.5rem;
        }

        .mb-n2,
        .my-n2 {
            margin-bottom: -0.5rem;
        }

        .ml-n2,
        .mx-n2 {
            margin-left: -0.5rem;
        }

        .m-n3 {
            margin: -1rem;
        }

        .mt-n3,
        .my-n3 {
            margin-top: -1rem;
        }

        .mr-n3,
        .mx-n3 {
            margin-right: -1rem;
        }

        .mb-n3,
        .my-n3 {
            margin-bottom: -1rem;
        }

        .ml-n3,
        .mx-n3 {
            margin-left: -1rem;
        }

        .m-n4 {
            margin: -1.5rem;
        }

        .mt-n4,
        .my-n4 {
            margin-top: -1.5rem;
        }

        .mr-n4,
        .mx-n4 {
            margin-right: -1.5rem;
        }

        .mb-n4,
        .my-n4 {
            margin-bottom: -1.5rem;
        }

        .ml-n4,
        .mx-n4 {
            margin-left: -1.5rem;
        }

        .m-n5 {
            margin: -3rem;
        }

        .mt-n5,
        .my-n5 {
            margin-top: -3rem;
        }

        .mr-n5,
        .mx-n5 {
            margin-right: -3rem;
        }

        .mb-n5,
        .my-n5 {
            margin-bottom: -3rem;
        }

        .ml-n5,
        .mx-n5 {
            margin-left: -3rem;
        }

        .m-auto {
            margin: auto;
        }

        .mt-auto,
        .my-auto {
            margin-top: auto;
        }

        .mr-auto,
        .mx-auto {
            margin-right: auto;
        }

        .mb-auto,
        .my-auto {
            margin-bottom: auto;
        }

        .ml-auto,
        .mx-auto {
            margin-left: auto;
        }

        table tr td {
            padding: 5px;
            margin: 0;
            vertical-align: top;

        }

        table tr th {
            padding: 10px;
            margin: 0;
            vertical-align: top;

        }

        .col-number {
            width: 2%;
        }

        .col-quantity {
            width: 8%;
        }

        .col-unity {
            width: 8%;
        }

        .col-description {
            width: 40%;
        }

        .col-price {
            width: 17%;
        }

        .col-discount {
            width: 5%;
        }

        .col-total {
            width: 20%;
        }
    </style>

    <table class="full-width my-3">
        <tr>
            <td width="47%" class="pl-3">
                <img src="data:image/png;base64,{{ $logo }}" alt="logo" width="150">
            </td>
            <td width="3%"></td>
            <td width="47%" class="border-box pl-1">
                <table class="full-width">
                    <tr>
                        <td width="80px">
                            <strong>Cot.:</strong>
                        </td>
                        <td width="8px">:</td>
                        <td class="font-xl font-bold">
                            {{ $quotation->identifier }}
                        </td>
                    </tr>
                    <tr style="background: #e9e9e9;">
                        <td width="80px">
                            <strong>Empresa:</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            {{ $quotation->company->trade_name }}
                        </td>
                    </tr>
                    <tr>
                        <td width="80px">
                            <strong>Dirección:</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            <span>
                                {{ $quotation->company->address_full }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="80px">
                            <strong>Teléfono:</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            <span>
                                {{ $quotation->company->phone }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="80px">
                            <strong>Email:</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            <span>
                                {{ $quotation->company->email }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="full-width my-3">
        <tr>
            <td width="47%" class="border-box pl-3">
                <table class="full-width">
                    <tr>
                        <td width="80px">
                            <strong>Razón Social</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            {{ $quotation->person->name }}
                        </td>
                    </tr>
                    <tr>
                        <td width="80px">
                            <strong>DNI/RUC</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            {{ $quotation->person->number }}
                        </td>
                    </tr>
                    <tr>
                        <td width="80px">
                            <strong>Dirección</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            <span>
                                {{ $quotation->person->address }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="3%"></td>
            <td width="47%" class="border-box pl-1">
                <table class="full-width">
                    <tr>
                        <td width="80px">
                            <strong>FE.:</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            {{ $quotation->date_of_issue->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td width="80px">
                            <strong>FV.:</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            {{ $quotation->date_of_issue->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td width="80px">
                            <strong>M. Pago</strong>
                        </td>
                        <td width="8px">:</td>
                        <td>
                            <span>
                                {{ $quotation->payment_method->description }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br />
    <table class="full-width mt-1 mb-0 border-box">
        <thead style="background: #dadada;">
            <tr>
                <th class="col-number" align="center">#</th>
                <th class="col-quantity" align="center">Cantidad</th>
                <th class="col-unity" align="center">Unidad</th>
                <th class="col-description" align="left">Descripción</th>
                <th class="col-price" align="right">P. Unit</th>
                <th class="col-discount" align="right">DTO.</th>
                <th class="col-total" align="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quotation->items as $item)
                <tr>
                    <td style="background: #e9e9e9;" align="center" class="border-bottom">{{ $loop->iteration }}</td>
                    <td align="center" class="border-bottom">{{ number_format($item->quantity, 0, '.', ',') }}</td>
                    <td style="background: #e9e9e9;" align="center" class="border-bottom">{{ $item->unit_type_id }}
                    </td>
                    <td align="left" class="border-bottom">
                        {{ $item->description }} - {{ $item->name }}
                    </td>
                    <td style="background: #e9e9e9;" align="right" class="border-bottom">S/
                        {{ number_format($item->unit_price, 2, '.', ',') }}</td>
                    <td align="right" class="border-bottom">{{ $item->discount }}</td>
                    <td style="background: #e9e9e9;" align="right" class="border-bottom">S/
                        {{ number_format($item->total, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td colspan="2" align="right" class="font-bold desc py-2">OP. GRAVADA</td>
                <td align="right" class="font-bold desc py-2">
                    S/ {{ number_format($quotation->subtotal, 2, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td colspan="2" align="right" class="font-bold desc py-2">IGV (18%)</td>
                <td align="right" class="font-bold desc py-2">
                    S/ {{ number_format($quotation->total_igv, 2, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td colspan="2" align="right" class="font-bold desc py-2">IMPORTE TOTAL</td>
                <td align="right" class="font-bold desc py-2">
                    S/ {{ number_format($quotation->total, 2, '.', ',') }}
                </td>
            </tr>
        </tfoot>
    </table>
    <table>
        <tr>
            <td>
                <p>Términos y condiciones: </p>
                <span>
                    La presente cotización es válida por un período de 30 días a partir de la fecha de emisión. Después
                    de este período, los precios y condiciones pueden estar sujetos a cambios.
                </span>
            </td>
        </tr>
    </table>

</body>

</html>
