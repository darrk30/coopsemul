<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('CargarPreguntaExamen', $filename, 's3');

            // Return URL of the uploaded file
            return response()->json([
                'url' => Storage::disk('s3')->url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $url = $request->input('url');
        $path = parse_url($url, PHP_URL_PATH);
        $path = ltrim($path, '/'); // remove leading slash if any

        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
            return response()->json(['message' => 'File deleted successfully.']);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
