<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use StdClass;
use Illuminate\Http\UploadedFile;

class UploadFileController extends Controller
{

    public function upload(Request $request)
    {
        $files = $request->file('file');
        $accept = $request->input('accept');
        $multiple = is_array($files);
        $response = $multiple ? [] : $this->packResponse($files, $accept);
        if ($multiple) {
            foreach ($files as $file) {
                $response[] = $this->packResponse($file, $accept);
            }
        }
        return !$response ? response()->json(['message' => __('Invalid file')], 422) : response()->json($response);
    }

    private function packResponse(UploadedFile $file, $accept)
    {
        $json = new StdClass();
        $json->name = $file->getClientOriginalName();
        $json->mime = $file->getClientMimeType();
        foreach(preg_split('/\s*,\s*/', $accept) as $mime) {
            $regexp = str_replace('\*', '.+', preg_quote($mime, '/'));
            if (!$accept || preg_match("/$regexp/", $json->mime)) {
                $json->path = $file->storePubliclyAs('', $this->getPublicName($file), 'public');
                $json->url = asset('storage/' . $json->path);
                return $json;
            }
        }
        return null;
    }

    private function getPublicName(UploadedFile $file)
    {
        if (!$file->guessExtension()) {
            return uniqid('', true) . '.' . $file->clientExtension();
        } else {
            return $file->hashName();
        }
    }
}
