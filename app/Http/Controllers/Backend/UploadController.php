<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $result = upload_file('editormd-image-file', $request);
        if ($result) {
            return response()->json(['success' => 1, 'url' => $result]);
        }
        return response()->json(['success' => 0]);
    }
}