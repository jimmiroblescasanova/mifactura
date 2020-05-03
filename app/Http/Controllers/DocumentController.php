<?php

namespace App\Http\Controllers;

use App;
use Auth;
use Storage;
use ZipArchive;
use CfdiUtils\Cfdi;
use App\addComprobante;
use App\addDocumentContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade as PDF;

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
        /*
         * TODO:
         * No se necesita recorrer toda la carpeta de archivos,
         * si tengo el guid de los xml a agregar
         */
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

    public function pdf($guid)
    {
        $document = addDocumentContent::where('GuidDocument', $guid)->first();
        $xmlContents = $document->Content;
        $comprobante = Cfdi::newFromString($xmlContents)->getQuickReader();

        $pdf = PDF::loadView('layouts.pdf', compact('comprobante'));
        return $pdf->stream();
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
        $document = addDocumentContent::where('GuidDocument', $guid)
            ->first();

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

}
