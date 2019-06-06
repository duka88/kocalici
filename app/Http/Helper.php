<?php 
namespace App\Http;

use Intervention\Image\Facades\Image;

class Helper{

	public static function uploadImageSize($uploadedImage){

        $imagePathXS = public_path('img/XS/');
           $imagePathMD = public_path('img/MD/');
          
           Image::configure(array('driver'=>'gd'));
           $imageName = $uploadedImage->getClientOriginalName();
           $savePathXS = $imagePathXS . $imageName;
           $image = Image::make($uploadedImage)
                    ->fit(60, 50)->save($savePathXS);

          

           $savePathMD = $imagePathMD . $imageName;
           $image = Image::make($uploadedImage)
                    ->fit(480, 300)->save($savePathMD);

         return $imageName;           
    }
}