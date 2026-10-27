<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class R2StorageService
{
    /**
     * Get the active storage disk ('r2' if configured, otherwise 'public').
     */
    public static function disk(): string
    {
        $r2Key = config('filesystems.disks.r2.key');

        return ! empty($r2Key) ? 'r2' : 'public';
    }

    /**
     * Compress an image and upload to storage.
     */
    public static function uploadCompressed(UploadedFile $file, string $folder = 'documents'): string
    {
        $disk = self::disk();
        $filename = Str::random(32).'.'.$file->getClientOriginalExtension();
        $targetPath = "{$folder}/{$filename}";

        $mimeType = $file->getMimeType();

        // If it's a JPEG or PNG and GD is available, compress it
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp']) && extension_loaded('gd')) {
            $compressedContent = self::compressImage($file->getRealPath(), $mimeType);
            Storage::disk($disk)->put($targetPath, $compressedContent, 'public');
        } else {
            Storage::disk($disk)->putFileAs($folder, $file, $filename, 'public');
        }

        return $targetPath;
    }

    /**
     * Delete a file from active storage disk.
     */
    public static function delete(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        $disk = self::disk();
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Get accessible URL for a stored file.
     * Uses secure application stream route to guarantee delivery and protect sensitive documents.
     */
    public static function url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        return url('/document/'.ltrim($path, '/'));
    }

    /**
     * Compress image using PHP GD to save bandwidth.
     */
    protected static function compressImage(string $filePath, string $mimeType): string
    {
        $image = match ($mimeType) {
            'image/jpeg' => @imagecreatefromjpeg($filePath),
            'image/png' => @imagecreatefrompng($filePath),
            'image/webp' => @imagecreatefromwebp($filePath),
            default => null,
        };

        $raw = file_get_contents($filePath);
        $fallback = $raw !== false ? $raw : '';

        if (! $image) {
            return $fallback;
        }

        // Get dimensions
        $width = imagesx($image);
        $height = imagesy($image);

        // Max width 1600px
        $maxWidth = 1600;
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = max(1, (int) round($height * ($maxWidth / $width)));
            $resized = imagecreatetruecolor($newWidth, $newHeight);

            if ($resized !== false) {
                // Preserve transparency if PNG
                if ($mimeType === 'image/png') {
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                }

                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $resized;
            }
        }

        ob_start();
        imagejpeg($image, null, 80); // 80% JPEG quality
        $output = ob_get_clean();
        imagedestroy($image);

        return ($output !== false && $output !== '') ? $output : $fallback;
    }
}
