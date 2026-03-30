<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class UploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'image', 'max:10240'],
        ]);

        $file = $request->file('file');
        $clientExt = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg'));

        // Un upload "propre" : on resize et on compresse côté serveur via Intervention.
        // On garde la même extension pour limiter les surprises côté affichage.
        $targetExt = in_array($clientExt, ['jpg', 'jpeg', 'png', 'webp'], true) ? ($clientExt === 'jpeg' ? 'jpg' : $clientExt) : 'jpg';

        $filename = Str::random(24).'.'.$targetExt;
        $relativePath = 'uploads/'.$filename;
        $fullPath = Storage::disk('public')->path($relativePath);

        $image = (new ImageManager(GdDriver::class))
            ->decodePath($file->getRealPath())
            ->orient()
            ->scaleDown(1800);

        // Qualité : permet de réduire le poids des images tout en restant net.
        $image->save($fullPath, 85);

        return response()->json([
            'url' => asset('storage/'.$relativePath),
            'path' => 'storage/'.$relativePath,
        ]);
    }
}
