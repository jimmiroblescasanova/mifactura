<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th>FECHA</th>
            <th>SERIE</th>
            <th>FOLIO</th>
            <th>CONCEPTO</th>
            <th>CARGO</th>
            <th>ABONO</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($documents as $document)
            <tr>
                <td>{{ $document->CFECHA }}</td>
                <td>{{ $document->CSERIEDOCUMENTO }}</td>
                <td>{{ $document->CFOLIO }}</td>
                <td>{{ $document->concepto->CNOMBRECONCEPTO }}</td>
                @if ($document->CIDDOCUMENTODE == 4)
                    <td>{{ $document->CTOTAL }}</td>
                    <td></td>
                @else
                    <td></td>
                    <td>{{ $document->CTOTAL*(-1) }}</td>
                @endif
            </tr>
        @endforeach
        <tr>
            <td>TOTALES</td>
            <td></td>
            <td></td>
            <td></td>
            <td>=SUM(E2:E{{ count($documents)+1 }})</td>
            <td>=SUM(F2:F{{ count($documents)+1 }})</td>
        </tr>
        </tbody>
    </table>
</body>
</html>
