<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index($fileName)
    {

        $filePath = "public/{$fileName}";
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        
        return Storage::download($filePath,$fileName,$headers);
    }
}   