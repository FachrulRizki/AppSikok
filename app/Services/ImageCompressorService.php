<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageCompressorService
{
    protected string $disk;
    protected string $folder;
    protected int $quality;
    protected ImageManager $imageManager;

    public function __construct(
        string $disk = 'public',
        string $folder = 'uploads',
        int $quality = 75
    ) {
        $this->disk = $disk;
        $this->folder = $folder;
        $this->quality = $quality;
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Compress & upload satu atau banyak file
     *
     * @param UploadedFile|array $files
     * @return array
     */
    public function compressAndUpload(UploadedFile|array $files, ?string $customFolder = null): array
    {
        $files = is_array($files) ? $files : [$files];
        $folder = $customFolder ?? $this->folder;

        $paths = [];

        foreach ($files as $file) {
            $filename = Str::uuid() . '.jpg';
            $path = $folder . '/' . $filename;

            $image = $this->imageManager->read($file)->toJpeg($this->quality);

            Storage::disk($this->disk)->put($path, (string) $image);

            $paths[] = $path;
        }

        return $paths;
    }
}
