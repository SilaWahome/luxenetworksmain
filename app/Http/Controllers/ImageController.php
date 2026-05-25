<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Serve and cache images stored in storage/app/public.
     */
    public function show($path)
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $file = file_get_contents($fullPath);
        $type = mime_content_type($fullPath);

        // Get the file size for Content-Length
        $size = filesize($fullPath);

        return response($file, 200)
            ->header('Content-Type', $type)
            ->header('Content-Length', $size)
            ->header('Cache-Control', 'public, max-age=31536000, immutable') // Cache for 1 year
            ->header('Pragma', 'public')
            ->header('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
    }
}
