<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * This contorller will be called when user clicked download link.
     * @param string $name :filename user requested to download
     * @return mixed
     */
    public function index($fileName)
    {

        $filePath = "public/{$fileName}";
        $mimeType = Storage::mimeType($filePath);
        $headers = [['Content-Type' => $mimeType]];
        
        return Storage::download($filePath,$fileName,$headers);
    }
}   