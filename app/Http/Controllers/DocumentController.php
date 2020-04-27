<?php

namespace App\Http\Controllers;

use App\addComprobante;
use App\addDocumentContent;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Storage;
use ZipArchive;

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

    public function download($file)
    {
        // return Storage::disk('public')->download($file);
        return response()->download(public_path('storage/'.$file));
    }

    public function xml()
    {
        $documento = $this->storeDocumentToPublic(request()->input('GuidDocument'));

        return response()->json([
            'filename' => $documento['FileName'],
        ], 200);
    }

    public function pdf()
    {
        $documento = addDocumentContent::where('GuidDocument', request()->input('GuidDocument'))
            ->get();

        return response()->json($documento, 200);
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

        return $document;
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
