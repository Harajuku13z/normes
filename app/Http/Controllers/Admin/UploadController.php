<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            // Images, PDF, vidéos courtes (reels) — max ~100 Mo pour les vidéos
            'file' => [
                'required',
                'file',
                'mimetypes:application/pdf,image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/webm',
                'max:102400',
            ],
        ]);

        $file = $request->file('file');
        $clientExt = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: ''));
        $mime = (string) ($file->getMimeType() ?: '');

        $isPdf = $clientExt === 'pdf' || $mime === 'application/pdf';

        $isVideo = str_starts_with($mime, 'video/')
            || in_array($clientExt, ['mp4', 'mov', 'webm', 'qt'], true);

        $isImage = ! $isPdf && ! $isVideo
            && in_array($clientExt, ['jpg', 'jpeg', 'png', 'webp'], true);

        if (! $isPdf && ! $isVideo && ! $isImage) {
            throw ValidationException::withMessages([
                'file' => ['Type de fichier non pris en charge (images JPEG/PNG/WebP, PDF, vidéo MP4/MOV/WebM).'],
            ]);
        }

        $targetExt = 'bin';
        if ($isPdf) {
            $targetExt = 'pdf';
        } elseif ($isVideo) {
            if (in_array($clientExt, ['mov', 'qt'], true) || $mime === 'video/quicktime') {
                $targetExt = 'mov';
            } elseif ($clientExt === 'webm' || $mime === 'video/webm') {
                $targetExt = 'webm';
            } else {
                $targetExt = 'mp4';
            }
        } else {
            $targetExt = in_array($clientExt, ['jpg', 'jpeg', 'png', 'webp'], true)
                ? ($clientExt === 'jpeg' ? 'jpg' : $clientExt)
                : 'jpg';
        }

        $filename = Str::random(24).'.'.$targetExt;
        $relativePath = 'uploads/'.$filename;
        $publicDir = public_path('uploads');
        File::ensureDirectoryExists($publicDir);
        $fullPath = $publicDir.DIRECTORY_SEPARATOR.$filename;

        $saved = false;
        if ($isImage) {
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
