<?php

namespace App\Http\Controllers;

use App;
use Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Storage;
use ZipArchive;
use App\addConceptos;
use App\addComprobante;
use App\addDocumentContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index($type)
    {
        $documentos = $this->getDocumentType($type);

        return view('documents.index', [
            'documentos' => $documentos,
            'type' => $type,
        ]);
    }

    public function download($file)
    {
         return Storage::disk('public')->download($file);
    }

    public function selected(Request $request)
    {
        $guid_array = [];
        $zip_file = 'download-'.NOW()->format('Ymd-His').'.zip';
        $zip = new ZipArchive;

        foreach ($request->id as $key) {
            $document = $this->findGuidDocument($request->type, $key);

             if (!Storage::disk('public')->exists($document.'.xml')) {
                 $documento = $this->storeDocumentToPublic($document);
             }
            array_push($guid_array, $document.'.xml');
        }
//  No se necesita recorrer toda la carpeta de archivos, si tengo el guid de los xml a agregar
        if ($zip->open(public_path('storage/'.$zip_file), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('storage'));

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);

                foreach ($guid_array as $guid) {

                    if (strtolower($guid) == $relativeNameInZipFile) {
                        $zip->addFile($value, $relativeNameInZipFile);
                    }
                }
            }
            $zip->close();
        }

        return response()->json([
            'filename' => $zip_file,
        ], 200);
    }

    public function xml()
    {
        $fileName = $this->storeDocumentToPublic(request()->input('GuidDocument'));

        return response()->json([
            'filename' => $fileName,
        ], 200);
    }

    public function test($guid)
    {
        $document = addDocumentContent::where('GuidDocument', $guid)->first();

        $xml = simplexml_load_file(public_path('/storage/'.$document->FileName));

//        $ns = $xml->getNamespaces(true);
//        $xml->registerXPathNamespace('c', $ns['cfdi']);
//        $xml->registerXPathNamespace('t', $ns['tfd']);

//        echo $xml->children('cfdi', TRUE)->count();
//        echo "<br />";

//        $xmlString = 'AQUI EL CFDI';
//        $xmlObject = simplexml_load_string($xmlString);
        $ns = $xml->getNamespaces(true);

        $response = $this->XMLNode($xml, $ns);

        return $response;
        //EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA
        /*foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
            echo $cfdiComprobante['Version'];
            echo "<br />";
            echo $cfdiComprobante['Fecha'];
            echo "<br />";
            echo $cfdiComprobante['Sello'];
            echo "<br />";
            echo $cfdiComprobante['Total'];
            echo "<br />";
            echo $cfdiComprobante['SubTotal'];
            echo "<br />";
            echo $cfdiComprobante['Certificado'];
            echo "<br />";
            echo $cfdiComprobante['FormaDePago'];
            echo "<br />";
            echo $cfdiComprobante['NoCertificado'];
            echo "<br />";
            echo $cfdiComprobante['TipoDeComprobante'];
            echo "<br />";
        }*/
        /*foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){
            echo $Emisor['Nombre'];
            echo "<br />";
            echo $Emisor['Rfc'];
            echo "<br />";
            echo $Emisor['RegimenFiscal'];
            echo "<br />";
        }*/
        /*foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){
            echo $Receptor['Rfc'];
            echo "<br />";
            echo $Receptor['Nombre'];
            echo "<br />";
            echo $Receptor['UsoCFDI'];
            echo "<br />";
        }*/
        /*foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as  $key => $Concepto){
            echo "<br />";
            echo $key .' - '. $Concepto['Cantidad'];
            echo "<br />";
            echo $Concepto['ClaveProdServ'];
            echo "<br />";
            echo $Concepto['ClaveUnidad'];
            echo "<br />";
            echo $Concepto['Unidad'];
            echo "<br />";
            echo $Concepto['Descripcion'];
            echo "<br />";
            echo $Concepto['Importe'];
            echo "<br />";
            echo $Concepto['ValorUnitario'];
            echo "<br />";
            echo $Concepto['NoIdentificacion'];
            echo "<br />";
            $impuestos = $xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado');
            print_r($impuestos[$key]);
            echo "<br>";

            dd($Concepto);
        }*/
        /*echo "<br>";
        $test = $xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado');
        dump($test);*/
        /*foreach($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado)
        {
            echo '-->'.$Traslado['Base'];
            echo "<br>";
        }*/
        /*foreach($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $key => $Retencion)
        {
            echo '-->'.$key .' - '. $Retencion['TasaOCuota'];
            echo "<br>";
        }*/
        /*foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){
            echo $Traslado['tasa'];
            echo "<br />";
            echo $Traslado['importe'];
            echo "<br />";
            echo $Traslado['impuesto'];
            echo "<br />";
            echo "<br />";
        }*/

//ESTA ULTIMA PARTE ES LA QUE GENERABA EL ERROR
        /*foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
            echo $tfd['SelloCFD'];
            echo "<br />";
            echo $tfd['FechaTimbrado'];
            echo "<br />";
            echo $tfd['UUID'];
            echo "<br />";
            echo $tfd['NoCertificadoSAT'];
            echo "<br />";
            echo $tfd['Version'];
            echo "<br />";
            echo $tfd['SelloSAT'];
        }*/
    }

    public function pdf($guid)
    {
//        $documento = addDocumentContent::where('GuidDocument', request()->input('GuidDocument'))->get();
        $documento = addComprobante::where('GuidDocument', $guid)
            ->first();

        $conceptos = addConceptos::where('GuidDocument', $guid)->get();

        $pdf = PDF::loadView('layouts.pdf', compact(['documento', 'conceptos']));
        return $pdf->stream();
//        return view('layouts.pdf', compact('documento'));
    }

    protected function getDocumentType($type)
    {
        return addComprobante::where([
            ['RFCReceptor', Auth::user()->rfc],
            ['TipoComprobante', $type]
        ])->get();
    }

    protected function storeDocumentToPublic($guid)
    {
        // Find the first document on database
        $document = addDocumentContent::where('GuidDocument', $guid)
            ->first();

        // Save file to storage folder
        Storage::disk('public')
            ->put('/' . $document['FileName'], $document['Content']);

        return $document['FileName'];
    }

    protected function findGuidDocument($type, $folio)
    {
        $document = addComprobante::where([
            ['TipoComprobante', $type],
            ['Folio', $folio],
        ])->first();

        return $document['GuidDocument'];
    }

    protected function XMLNode($XMLNode, $ns)
    {
        //
        $nodes = array();
        $response = array();
        $attributes = array();

        // first item ?
        $_isfirst = true;

        // each namespace
        //  - xmlns:cfdi="http://www.sat.gob.mx/cfd/3"
        //  - xmlns:tfd="http://www.sat.gob.mx/TimbreFiscalDigital"
        foreach ($ns as $eachSpace) {
            //
            // each node
            foreach ($XMLNode->children($eachSpace) as $_tag => $_node) {
                //
                $_value = $this->XMLNode($_node, $ns);
                // exists $tag in $children?
                if (key_exists($_tag, $nodes)) {
                    if ($_isfirst) {
                        $tmp = $nodes[$_tag];
                        unset($nodes[$_tag]);
                        $nodes[] = $tmp;
                        $_isfirst = false;
                    }
                    $nodes[] = $_value;
                } else {
                    $nodes[$_tag] = $_value;
                }
            }
        }

        //
        $attributes = array_merge(
            $attributes,
            (array)current($XMLNode->attributes())
        );

        // nodes ?
        if (count($nodes)) {
            $response = array_merge(
                $response,
                $nodes
            );
        }

        // attributes ?
        if (count($attributes)) {
            $response = array_merge(
                $response,
                $attributes
            );
        }

        return (empty($response) ? null : $response);
    }

}
