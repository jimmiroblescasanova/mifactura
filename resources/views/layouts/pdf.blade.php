<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>

    <style type="text/css" media="all">
        body {
            background: white;
            font-family: "Nunito", sans-serif;
            font-size: 9px;
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

        .row {
            display: block;
            margin-bottom: .5em;
        }
        .column {
            display: inline-block;
            vertical-align: top;
        }
        .table {
            border: 0.5px solid #999;
        }
        .table tr:first-child {
            background-color: #f2f2f2;
        }
        .table td {
            font-size: 8px;
            padding: 3px;
        }
        /* Estilos para los encabezados */
        #encabezado {
            margin-bottom: 25px;
        }
        #encabezado .logo {
            text-align: left;
            vertical-align: top;
            width: 100px;
        }
        #encabezado .fecha {
            text-align: right;
            vertical-align: top;
        }
        #encabezado .emisor {
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }
        /* Conceptos */
        #conceptos table td{
            border: 0.5px solid #999;
            font-size: 8px;
        }
        #conceptos table tr:first-child {
            text-align: center;
            vertical-align: middle;
        }
        #conceptos table tr:nth-child(odd) {
            background-color:#f2f2f2;
        }
        #conceptos .impuestos {
            font-size: 7px;
        }
        /* Zona de leyendas y subtotales */
        #impuestos table td {
            text-align: right;
        }
        #impuestos .leyendas {
            text-align: left;
        }

        #cadenas .cadenasDigitales {
            font-size: 6px;
        }
        #cadenas .qr {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
{{-- Encabezados --}}
<div class="row" id="encabezado">
    <table>
        <tr>
            <td class="logo">
                <img src="{{ public_path('logo.jpg') }}" alt="logotipo" width="80px">
            </td>
            <td class="fecha">
                <small>Lugar de Expedición: {{ $comprobante['LugarExpedicion'] }} <br>
                    Fecha:  {{ $comprobante['Fecha'] }}</small>
            </td>
        </tr>
        <tr class="emisor">
            <td colspan="2">
                <b>{{ $comprobante->Emisor['Nombre'] }}</b>
            </td>
        </tr>
        <tr class="emisor">
            <td colspan="2">
                <strong>RFC:</strong> {{ $comprobante->Emisor['RFC'] }} -
                <strong>Régimen Fiscal:</strong> {{ $comprobante->Emisor['RegimenFiscal'] }}
            </td>
        </tr>
    </table>
</div>
{{-- Datos fiscales del documento --}}
<div class="row" id="datosDocumento">
    <div class="column" style="width: 40%">
        <table class="table">
            <tr>
                <td>
                    <b>Folio Fiscal:</b> {{ $comprobante->Complemento->TimbreFiscalDigital['UUID'] }}
                </td>
            </tr>
            <tr>
                <td>
                    Fecha SAT: {{ $comprobante->Complemento->TimbreFiscalDigital['FechaTimbrado'] }} <br>
                    No. de serie del Certificado del SAT: {{ $comprobante->Complemento->TimbreFiscalDigital['NoCertificadoSAT'] }}
                    <br>
                    Serie del Certificado del emisor: {{ $comprobante['NoCertificado'] }} <br>
                    Versión CFDI: {{ $comprobante['Version'] }}
                </td>
            </tr>
        </table>
    </div>
    <div class="column" style="width: 15%">&nbsp;</div>
    <div class="column" style="width: 40%">
        <table class="table">
            <tr>
                <td>
                    <b>Serie y Folio: </b> {{ $comprobante->Receptor['Nombre'] }}
                </td>
            </tr>
            <tr>
                <td>
                    Tipo de Comprobante: {{ $comprobante['TipoDeComprobante'] }}<br>
                    Forma de Pago: {{ $comprobante['FormaPago'] }} <br>
                    Método de Pago: {{ $comprobante['MetodoPago'] }}<br>
                    Moneda: {{ $comprobante['Moneda'] }}
                </td>
            </tr>
        </table>
    </div>
</div>
{{-- Receptor --}}
<div class="row" id="receptor">
    <table class="table">
        <tr>
            <td><strong>FACTURADO A:</strong> {{ $comprobante->Receptor['Nombre'] }}</td>
        </tr>
        <tr>
            <td>
                R.F.C.: {{ $comprobante->Receptor['Rfc'] }}<br>
                USO CFDI: {{ $comprobante->Receptor['UsoCFDI'] }}
            </td>
        </tr>
    </table>
</div>
{{-- Movimientos del documento --}}
<div class="row" id="conceptos">
    <table>
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
{{-- Zona de leyendas y subtotales --}}
<div class="row" id="impuestos">
    <table>
        <tr>
            <td rowspan="4" colspan="4" class="leyendas">
                Este documento es una representación impresa de un CFDI. <br>
{{--                CANTIDAD CON LETRA--}}
            </td>
            <td>Subtotal:</td>
            <td>$ {{ convertir_a_numero($comprobante['Subtotal']) }}</td>
        </tr>
        <tr>
            <td>Impuestos Trasladados:</td>
            <td>$ {{ convertir_a_numero($comprobante->Impuestos['TotalImpuestosTrasladados']) }}</td>
        </tr>
        <tr>
            <td>Impuestos Retenidos:</td>
            <td>
                @if (isset($comprobante->Impuestos['TotalImpuestosRetenidos']))
                    $ {{ $comprobante->Impuestos['TotalImpuestosRetenidos'] }}
                @else
                    $ 0.00
                @endif
            </td>
        </tr>
        <tr>
            <td>TOTAL:</td>
            <td>$ {{ convertir_a_numero($comprobante['Total']) }}</td>
        </tr>
    </table>
</div>
{{-- Cadenas digitales --}}
<div class="row" id="cadenas">
    <table>
        <tr>
            <td rowspan="2" class="qr">
                <img alt="QR" src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(125)->generate('https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id='. $comprobante->Complemento->TimbreFiscalDigital['UUID'])) }} ">
            </td>
            <td style="width: 75%;">Sello digital emisor: <br>
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
            <td colspan="2">Cadena Original <br>
                <span class="cadenasDigitales">
                    ||{{ $comprobante->Complemento->TimbreFiscalDigital['Version'] }}
                    |{{ $comprobante->Complemento->TimbreFiscalDigital['UUID'] }}
                    |{{ $comprobante->Complemento->TimbreFiscalDigital['FechaTimbrado'] }}
                    |{{ $comprobante->Complemento->TimbreFiscalDigital['RfcProvCertif'] }}
                    |{{ $comprobante->Complemento->TimbreFiscalDigital['SelloCFD'] }}
                    |{{ $comprobante->Complemento->TimbreFiscalDigital['NoCertificadoSAT'] }}||
                </span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
