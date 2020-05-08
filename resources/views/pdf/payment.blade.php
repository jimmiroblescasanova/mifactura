<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Complemento de Pago</title>

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
        .conceptos table td{
            border: 0.5px solid #999;
            font-size: 8px;
        }
        .conceptos table tr:first-child {
            text-align: center;
            vertical-align: middle;
        }
        .conceptos table tr:nth-child(odd) {
            background-color:#f2f2f2;
        }
        .conceptos .impuestos {
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
{{--    Columna izquierda--}}
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
{{--    Columna derecha--}}
    <div class="column" style="width: 40%">
        <table class="table">
            <tr>
                <td>
                    <b>Serie y Folio: </b> {{ $comprobante['Serie'] .''. $comprobante['Folio'] }}
                </td>
            </tr>
            <tr>
                <td>
                    Tipo de Comprobante: {{ $comprobante['TipoDeComprobante'] }}<br>
                    Fecha de Pago: {{ $comprobante->Complemento->Pagos->Pago['FechaPago'] }} <br>
                    Forma de Pago: {{ $comprobante->Complemento->Pagos->Pago['FormaDePagoP'] }} <br>
                    Moneda: {{ $comprobante->Complemento->Pagos->Pago['MonedaP'] }} <br>
                    Total del Pago: ${{ convertir_a_numero($comprobante->Complemento->Pagos->Pago['Monto']) }}
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
<div class="row conceptos">
    <table>
        <tr>
            <td>Cantidad</td>
            <td>Unidad</td>
            <td>Clave Prod/Serv</td>
            <td>Descripción</td>
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
        @endforeach
    </table>
</div>
{{-- Documentos relacionados --}}
<div class="row conceptos">
    <table>
        <tr>
            <td>Folio</td>
            <td style="width: 40%;">UUID</td>
            <td>Método de Pago</td>
            <td>Moneda</td>
            <td>Importe Pagado</td>
            <td>Saldo Anterior</td>
            <td>Saldo Insoluto</td>
        </tr>
        @foreach (($comprobante->Complemento->Pagos->Pago)() as $row)
            <tr>
                <td>{{ $row['Folio'] }}</td>
                <td>{{ $row['IdDocumento'] }}</td>
                <td>{{ $row['MetodoDePagoDR'] }}</td>
                <td>{{ $row['MonedaDR'] }}</td>
                <td>{{ convertir_a_numero($row['ImpPagado']) }}</td>
                <td>{{ convertir_a_numero($row['ImpSaldoAnt']) }}</td>
                <td>{{ convertir_a_numero($row['ImpSaldoInsoluto']) }}</td>
            </tr>
        @endforeach
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
        <tr>
            <td colspan="2" style="text-align: center;"><br>Este documento es una representación impresa de un CFDI</td>
    </table>
</div>
</body>
</html>
