<?php

namespace App\Http\Controllers\Traits;

use Intervention\Image\Laravel\Facades\Image;


trait ImageHandlerTrait
{
 
    private function handleImageUpload($imageFile, $path)
    {
        // Sanitize filename - remove special characters and ensure safe filename
        $originalName = $imageFile->getClientOriginalName();
        $extension = $imageFile->getClientOriginalExtension();
        $sanitizedName = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $imageName = time() . '-' . $sanitizedName . '.' . $extension;
        
        $storagePath = storage_path("app/public/$path");

        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        // Read and process image with memory optimization
        $image = Image::read($imageFile);
        
        // Crop to 500x400 directly without saving twice
        $image->cover(500, 400);
        
        // Save the cropped image
        $image->save($storagePath . '/' . $imageName);

        return "$path/$imageName";
    }
}


 