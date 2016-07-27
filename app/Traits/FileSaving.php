<?php namespace App\Traits;

use Image;
use ColorThief\ColorThief;
use Mexitek\PHPColors\Color;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileSaving
{
    /**
     * Save the current image
     * @return boolean|string the image’s path or false on failure
     */
    public function saveImageToDisk($file, $resourceName, $croppedWidth = 300, $croppedHeight = 300)
    {
        $path = public_path() . '/uploads/';

        if ($file instanceof UploadedFile) {
            $fileName     = str_slug($resourceName) . '_' .  mt_rand(0, 9999) . '.' . $file->getClientOriginalExtension();
            $originalPath = $path . 'original_' . $fileName;
            $file->move($path, 'original_' . $fileName);
        } elseif (is_string($file)) {
            $fileName     = $file;
            $originalPath = $path . 'original_' . $fileName;
        } else {
            return false;
        }

        if (! file_exists($originalPath)) {
            return false;
        }

        // Create thumbnail
        $thumb = Image::make($originalPath);

        $thumb->fit($croppedWidth, $croppedHeight);
        $thumb->save($path . 'thumb_' . $fileName);

        // Create resized images
        // =====================
        $image = Image::make($originalPath);

        // Large
        $image->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($path . 'large_' . $fileName);

        // Normal
        $image->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($path . $fileName);

        // Small
        $image->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($path . 'small_' . $fileName);

        return $fileName;
    }

    /**
     * Return a string ratio depending on the ratio to determine if
     * the given image is a wide landscape or is closer to portrait
     */
    public function getLogoRatio($path)
    {
        $size = getimagesize($path);

        // Get ratio by dividing width by height
        $ratio = $size[0] / $size[1];

        if ($ratio < 0.9) {
            return 'portrait';
        }

        if ($ratio > 1.3) {
            return 'landscape';
        }

        return 'square';
    }

    /**
     * Get dominant color of given image as a CSS formated string
     * @return string
     */
    public function getLogoColorAsCssFormatedRgbValues($path)
    {
        $rgbValues = ColorThief::getColor($path, 7);

        if ($rgbValues[0] > 160 || $rgbValues[1] > 160 || $rgbValues[2] > 160) {
            $rgbValues["R"] = $rgbValues[0];
            $rgbValues["G"] = $rgbValues[1];
            $rgbValues["B"] = $rgbValues[2];

            $hslValues = Color::rgbToHex($rgbValues);

            $color = new Color($hslValues);

            if ($rgbValues[0] > 200 || $rgbValues[1] > 200 || $rgbValues[2] > 200) {
                $color = $color->darken(30);
            } else {
                $color = $color->darken(10);
            }

            $rgbValues = Color::hexToRgb($color);
        }

        return 'rgb('. implode(',', $rgbValues) .')';
    }

    /**
     * Save PDF to disk
     * @param  UploadedFile|null $file
     *
     * @return boolean|string Failed or path to file
     */
    private function savePdfToDisk($file, $fileName, $subPath = '')
    {
        if ($file === null) {
            return false;
        }

        $path = public_path() . '/uploads/' . $subPath . '/';

        // Erase previous file if exists
        if (file_exists($path . $fileName . '.pdf')) {
            @unlink($path . $fileName . '.pdf');
        }

        // Atempt to write and return file name + extension
        if ($file->move($path, $fileName . '.pdf')) {
            return $fileName . '.pdf';
        }
    }
}
