<?php

namespace App\Services;

use App\Models\Vehicle;
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

    public static function deleteVehicleImages($vehicleId, $request, $input, $path) {
        try {
            $vehicle = Vehicle::find($vehicleId);
            $images = $request->file($input);
            if ($images) {
                $currnet_images = $vehicle->images;
                foreach ($currnet_images as $key => $image) {
                    unlink(public_path($path) .'/'. $image->file);
                    $image->delete();
                }
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    public static function deleteVehicleImage($vehicleId, $request, $input, $path) {
        try {
            $vehicle = Vehicle::find($vehicleId);
            $image = $request->file($input);
            if ($image) {
                $currnet_images = $vehicle->cover_image_file;
                unlink(public_path($path) .'/'. $currnet_images);
                $vehicle->cover_image_file = null;
                $vehicle->save();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
