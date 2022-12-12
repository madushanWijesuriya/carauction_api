<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function saveMultipleImages($request, $input, $path){
        try{
            $file_names = [];
            $images = $request->file($input);
            foreach ($images as $key => $image) {
                $new_image  = rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path($path), $new_image);
                $file_names[$key]['file'] = $new_image;
                $file_names[$key]['full_url'] = $path. '/'. $new_image;
                
            }
            return $file_names;
        }catch(Exception $e){
            dd($file_names,$key,$e->getMessage());
            return false;
        }
    }
    public static function saveImage($request, $input, $path){
        try{
            $image = $request->file($input);
            $new_image  = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $new_image);
            return [
                'file' => $new_image,
                'full_url' => $path. '/'. $new_image
            ];
        }catch(Exception $e){
            return false;
        }
    }
}
