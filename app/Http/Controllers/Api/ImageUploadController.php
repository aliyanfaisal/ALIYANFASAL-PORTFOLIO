<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class ImageUploadController extends Controller
{
    private const MAX_DECODED_BYTES = 15 * 1024 * 1024;

    private const DIRECTORY = 'generated';

    private const IMAGE_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    /**
     * Store a base64-encoded image on the public disk and return its public URL.
     *
     * Existing files are never overwritten: a -2, -3, ... suffix is appended to
     * the name instead. The extension is always derived from the detected image
     * type rather than trusted from the supplied filename.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'image_base64' => ['required', 'string'],
            'filename' => ['required', 'string', 'max:255'],
        ]);

        $contents = $this->decodeImage($data['image_base64']);
        $extension = $this->detectExtension($contents);
        $stem = $this->sanitizeStem($data['filename']);

        try {
            $disk = Storage::disk('public');
            $filename = $this->uniqueFilename($stem, $extension);

            $disk->put(self::DIRECTORY.'/'.$filename, $contents);
        } catch (Throwable $exception) {
            report($exception);
            Log::error('Image upload failed to store file.', ['message' => $exception->getMessage()]);

            return response()->json(['message' => 'Failed to store the image.'], 500);
        }

        return response()->json([
            'status' => 'uploaded',
            'url' => asset('storage/'.self::DIRECTORY.'/'.$filename),
            'filename' => $filename,
        ], 201);
    }

    private function decodeImage(string $base64): string
    {
        $base64 = preg_replace('/\s+/', '', $base64);

        if (strlen($base64) > (int) ceil(self::MAX_DECODED_BYTES / 3) * 4) {
            throw ValidationException::withMessages([
                'image_base64' => 'The image exceeds the maximum size of 15MB.',
            ]);
        }

        $contents = base64_decode($base64, true);

        if ($contents === false || $contents === '') {
            throw ValidationException::withMessages([
                'image_base64' => 'The image_base64 value is not valid base64 (send the raw string without a data: prefix).',
            ]);
        }

        if (strlen($contents) > self::MAX_DECODED_BYTES) {
            throw ValidationException::withMessages([
                'image_base64' => 'The image exceeds the maximum size of 15MB.',
            ]);
        }

        return $contents;
    }

    private function detectExtension(string $contents): string
    {
        $info = @getimagesizefromstring($contents);
        $extension = $info === false ? null : (self::IMAGE_EXTENSIONS[$info['mime']] ?? null);

        if ($extension === null) {
            throw ValidationException::withMessages([
                'image_base64' => 'The decoded content is not a supported image (jpg, png, gif, webp).',
            ]);
        }

        return $extension;
    }

    private function sanitizeStem(string $filename): string
    {
        $basename = basename(str_replace('\\', '/', $filename));
        $stem = pathinfo($basename, PATHINFO_FILENAME);
        $stem = preg_replace('/[^A-Za-z0-9_.-]/', '', $stem);
        $stem = trim(preg_replace('/\.{2,}/', '.', $stem), '.');

        if ($stem === '') {
            throw ValidationException::withMessages([
                'filename' => 'The filename must contain at least one letter, number, dash or underscore.',
            ]);
        }

        return $stem;
    }

    private function uniqueFilename(string $stem, string $extension): string
    {
        $disk = Storage::disk('public');
        $filename = "{$stem}.{$extension}";
        $suffix = 2;

        while ($disk->exists(self::DIRECTORY.'/'.$filename)) {
            $filename = "{$stem}-{$suffix}.{$extension}";
            $suffix++;
        }

        return $filename;
    }
}
