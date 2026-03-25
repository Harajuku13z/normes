<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'image', 'max:10240'],
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        return response()->json([
            'url' => asset('storage/'.$path),
            'path' => 'storage/'.$path,
        ]);
    }
}
