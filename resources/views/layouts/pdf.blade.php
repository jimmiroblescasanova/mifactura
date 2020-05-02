<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>

    <style type="text/css" media="all">
        body {
            background: white;
            font-family: "Nunito", sans-serif;
            font-size: 10px;
        }
        p {
            padding: 0;
            margin: 0;
        }
        table {
            /*border: 1px solid #999;*/
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }
        th, td {
            padding: 0;
            word-wrap: break-word;
        }
        /*tr:first-child {
            background-color: #f2f2f2;
        }*/

        .table-row-color tr:nth-child(odd) {
            background-color:#f2f2f2;
        }

        .table-borderless td {
            border: 0;
        }

        .table-bordered td {
            border: 1px solid #999;
        }

        .row {
            display: block;
            margin-bottom: .5em;
        }

        .impuestos {
            font-size: 8px;
        }
        .cadenasDigitales {
            font-size: 7px;
        }
        .table-white-space {
            background-color: white;
            border-top: 0;
            border-bottom: 0;
            width: 10%;
        }
        #DatosReceptor {
            border: 0.5px solid #999;
        }
        #DatosReceptor tr:first-child {
            background-color: #f2f2f2;
        }
        #DatosReceptor td {
            padding-left: 5px;
        }

    </style>
</head>
<body>
<div class="row" style="margin-bottom: 30px;">
    <table>
        <tr>
            <td>
                <img src="{{ public_path('logo.jpg') }}" alt="logotipo" width="80px">
                <small>{{ $comprobante['LugarExpedicion'] .', '. $comprobante['Fecha'] }}</small>
            </td>
        </tr>
        <tr>
            <td>
                <span><b>EMITIDO POR:</b> {{ $comprobante->Emisor['Nombre'] }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span>RFC: {{ $comprobante->Emisor['RFC'] }}</span>
                <span><strong>Régimen Fiscal:</strong> {{ $comprobante->Emisor['RegimenFiscal'] }}</span>
            </td>
        </tr>
    </table>
</div>

<div class="row" style="background-color: #ced4da;">
    <div style="width: 45%; background-color: #1b4b72">
        <p>Folio Fiscal: {{ $comprobante->Complemento->TimbreFiscalDigital['UUID'] }}</p>
        <p>Fecha SAT:</p>
        <p>Serie del Certificado del emisor:</p>
        <p>No. de serie del Certificado del SAT:</p>
        <p>Versión CFDI:</p>
    </div>
{{--    <div style="width: 10%; display: inline-block;"></div>--}}
    <div style="width: 45%; background-color: #1d643b; display: inline-block;">
        <p>Serie y Folio:</p>
        <p>Tipo de comprobante</p>
        <p>Método de Pago:</p>
        <p>Moneda:</p>
    </div>
</div>

<div class="row">
    <table id="DatosReceptor">
        <tr>
            <td><strong>FACTURADO A:</strong> {{ $comprobante->Receptor['Nombre'] }}</td>
        </tr>
        <tr>
            <td><strong>USO CFDI:</strong> </td>
        </tr>
    </table>
</div>

<div class="row">
    <table class="table-row-color table-bordered">
        <tr>
            <td>Cantidad</td>
            <td>Unidad</td>
            <td>Clave Prod/Serv</td>
            <td style="width: 50%;">Descripción</td>
            <td>Precio Unitario</td>
            <td>Importe</td>
        </tr>
        @foreach (($comprobante->Conceptos)() as $row)
            <tr>
                <td>{{ $row['Cantidad'] }}</td>
                <td>{{ $row['ClaveUnidad'] }}</td>
                <td>{{ $row['ClaveProdServ'] }}</td>
                <td>{{ $row['Descripcion'] }}</td>
                <td>{{ $row['ValorUnitario'] }}</td>
                <td>{{ $row['Importe'] }}</td>
            </tr>
            <tr class="impuestos">
                <td colspan="6">
                    @if (isset($row->Impuestos->Traslados))
                        Impuestos trasladados:
                        @foreach (($row->Impuestos->Traslados)() as $traslado)
                            Tipo: {{ $traslado['Impuesto'] }} - {{ TipoDeImpuestos($traslado['Impuesto']) }},
                            Importe: {{ $traslado['Importe'] }},
                            Tasa o Cuota: {{ $traslado['TasaOCuota'] }};
                        @endforeach
                        <br>
                    @endif

                    @if (isset($row->Impuestos->Retenciones))
                        Impuestos retenidos:
                        @foreach (($row->Impuestos->Retenciones)() as $retencion)
                            Tipo: {{ $retencion['Impuesto'] }} - {{ TipoDeImpuestos($retencion['Impuesto']) }},
                            Importe: {{ $retencion['Importe'] }},
                            Tasa o Cuota: {{ $retencion['TasaOCuota'] }};
                        @endforeach
                        <br>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>

<div class="row">
    <table>
        <tr>
            <td rowspan="4" colspan="4">
                Este documento es una representación impresa de un CFDI. <br>
                CANTIDAD CON LETRA
            </td>
            <td>Subtotal:</td>
            <td>{{ $comprobante['Subtotal'] }}</td>
        </tr>
        <tr>
            <td>Impuestos Trasladados:</td>
            <td>{{ $comprobante->Impuestos['TotalImpuestosTrasladados'] }}</td>
        </tr>
        <tr>
            <td>Impuestos Retenidos:</td>
            <td>{{ $comprobante->Impuestos['TotalImpuestosRetenidos'] }}</td>
        </tr>
        <tr>
            <td>TOTAL:</td>
            <td>{{ $comprobante['Total'] }}</td>
        </tr>
    </table>
</div>

<div class="row">
    <table class="table-borderless">
        <tr>
            <td rowspan="2">QR</td>
            <td>Sello digital emisor: <br>
                <span class="cadenasDigitales">
                    {{ $comprobante->Complemento->TimbreFiscalDigital['SelloCFD'] }}
                </span>
            </td>
        </tr>
        <tr>
            <td>Sello digital SAT: <br>
                <span class="cadenasDigitales">
                    {{ $comprobante->Complemento->TimbreFiscalDigital['SelloSAT'] }}
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">Cadena Original</td>
        </tr>
    </table>
</div>
</body>
</html>
