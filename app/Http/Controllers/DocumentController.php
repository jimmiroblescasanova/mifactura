<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\addComprobante;
use App\addDocumentContent;
use Illuminate\Http\Request;
use ZipArchive;

class DocumentController extends Controller
{
    public function index($type)
    {
        $documentos = $this->getDocumentType($type);

        return view('documents.index', compact('documentos'));
    }

    public function selected(Request $request)
    {
        $zip_file = url('archivo_comprimido');
        $zip = new ZipArchive();

        $files = \File::files(public_path('storage'));

        if ($zip->open($zip_file . '.zip', ZipArchive::CREATE) === TRUE) {
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }

        return response()->download($zip_file . '.zip');
    }

    public function download($file)
    {
        return Storage::disk('public')
            ->download('' . $file);
    }

    public function xml()
    {
        $document = addDocumentContent::where('GuidDocument', request()->input('GuidDocument'))
            ->first();

        // Save file to storage folder
        Storage::disk('public')
            ->put('/' . $document['FileName'], $document['Content']);

        return response()->json([
            'filename' => $document['FileName'],
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
}
