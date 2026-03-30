<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            // Supporte images (pour le site) + PDF (doc technique)
            'file' => ['required', 'file', 'mimetypes:application/pdf,image/jpeg,image/png,image/webp', 'max:20480'],
        ]);

        $file = $request->file('file');
        $clientExt = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: ''));
        $mime = (string) ($file->getMimeType() ?: '');

        $isPdf = $clientExt === 'pdf' || $mime === 'application/pdf';

        $targetExt = $isPdf
            ? 'pdf'
            : (in_array($clientExt, ['jpg', 'jpeg', 'png', 'webp'], true) ? ($clientExt === 'jpeg' ? 'jpg' : $clientExt) : 'jpg');

        $filename = Str::random(24).'.'.$targetExt;
        $relativePath = 'uploads/'.$filename;
        $publicDir = public_path('uploads');
        File::ensureDirectoryExists($publicDir);
        $fullPath = $publicDir.DIRECTORY_SEPARATOR.$filename;

        $saved = false;
        if (! $isPdf) {
            $saved = $this->saveWithInterventionIfAvailable($file, $fullPath);
        }

        if (! $saved) {
            $file->move($publicDir, $filename);
        }

        return response()->json([
            'url' => asset($relativePath),
            'path' => $relativePath,
        ]);
    }

    /**
     * Si intervention/image est installé (composer), resize + compression.
     * Sinon : false pour laisser le move() natif faire le travail (évite "Class not found" en prod).
     */
    private function saveWithInterventionIfAvailable(UploadedFile $file, string $fullPath): bool
    {
        if (! class_exists(\Intervention\Image\ImageManager::class)) {
            return false;
        }

        if (! class_exists(\Intervention\Image\Drivers\Gd\Driver::class)) {
            return false;
        }

        try {
            $managerClass = \Intervention\Image\ImageManager::class;
            $driverClass = \Intervention\Image\Drivers\Gd\Driver::class;

            $image = (new $managerClass($driverClass))
                ->decodePath($file->getRealPath())
                ->orient()
                ->scaleDown(1800);

            $image->save($fullPath, 85);

            return is_file($fullPath);
        } catch (\Throwable) {
            if (is_file($fullPath)) {
                @unlink($fullPath);
            }

            return false;
        }
    }
}
