<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>

    <style type="text/css" media="all">
        body {
            background: white;
        }
        table {
            margin: 0;
            padding: 0;
            width: 100%;
        }
        table tr td{
            border: solid 1px gray;
            padding: 0;
        }
        table.right {
            float: right;
        }
        tr:nth-child(odd) {
            background-color:#f2f2f2;
        }
        .row {
            display: flex;
            margin-bottom: .5em;
        }
    </style>
</head>
<body>
<div class="row">
    <table class="table">
        <tr>
            <td>
                <img src="{{ public_path('logo.jpg') }}" alt="logotipo" width="80px">
                <small>{{ $documento->LugarExpDesc .', '. $documento->Fecha->format('d \d\e F \d\e\l Y \a \l\a\s h:i:s a') }}</small>
            </td>
        </tr>
        <tr>
            <td>
                <span><b>EMITIDO POR:</b> {{ $documento->NombreEmisor }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span><b>RFC:</b> {{ $documento->RFCEmisor }}</span>
                <span><strong>Régimen Fiscal:</strong> {{ $documento->RegimenEmisor .' - '. $documento->RegimenEmisorDesc }}</span>
            </td>
        </tr>
    </table>
</div>

<div class="row">
    <table class="table" style="width: 45%;">
        <tr>
            <td>Folio Fiscal:</td>
        </tr>
        <tr>
            <td>Fecha SAT:</td>
        </tr>
    </table>
    <table class="table right" style="width: 45%;">
        <tr>
            <td>Folio:</td>
        </tr>
        <tr>
            <td>Tipo de Comprobante:</td>
        </tr>
    </table>
</div>

<div class="row">
    <table class="table">
        <tr>
            <td>FACTURADO A: {{ $documento->NombreReceptor }}</td>
        </tr>
        <tr>
            <td>USO CFDI: </td>
        </tr>
    </table>
</div>

<div class="row">
    <table class="table">
        <tr>
            <td>Cantidad</td>
            <td>Unidad</td>
            <td>Clave Prod/Serv</td>
            <td>Descripción</td>
            <td>Precio Unitario</td>
            <td>Importe</td>
        </tr>
        @foreach ($conceptos as $row)
            <tr>
                <td>{{ $row->Cantidad }}</td>
                <td>{{ $row->ClaveUnidad }}</td>
                <td>{{ $row->CveProdSer }}</td>
                <td>{{ $row->Descripcion }}</td>
                <td>{{ $row->ValorUnitario }}</td>
                <td>{{ $row->Importe }}</td>
            </tr>
        @endforeach
    </table>
</div>
<div class="row">
    <table>
        <tr>
            <td rowspan="4" colspan="4">
                Este documento es una representación impresa de un CFDI.
            </td>
            <td>Subtotal:</td>
            <td>{{ $documento->Subtotal }}</td>
        </tr>
        <tr>
            <td>Impuestos Trasladados:</td>
            <td>{{ $documento->TotalImpTraslado }}</td>
        </tr>
        <tr>
            <td>Impuestos Retenidos:</td>
            <td>{{ $documento->TotalImpRetenidos }}</td>
        </tr>
        <tr>
            <td>TOTAL:</td>
            <td>{{ $documento->Total }}</td>
        </tr>
    </table>
</div>

<div class="row">
    <table>
        <tr>
            <td rowspan="2">QR</td>
            <td>Sello digital emisor</td>
        </tr>
        <tr>
            <td>Sello digital SAT</td>
        </tr>
        <tr>
            <td colspan="2">Cadena Original</td>
        </tr>
    </table>
</div>
</body>
</html>
