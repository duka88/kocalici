<?php 
namespace App\Http;

use Intervention\Image\Facades\Image;

class Helper{

	public static function uploadImageSize($uploadedImage, $uploadedImageName=null){

        $imagePathXS = public_path('img/XS/');
           $imagePathMD = public_path('img/MD/');
          
           Image::configure(array('driver'=>'gd'));
        if($uploadedImageName != null){
           $imageName = $uploadedImageName;
         }else{
           $imageName = $uploadedImage->getClientOriginalName();
         }
           
           $savePathXS = $imagePathXS . $imageName;
           $image = Image::make($uploadedImage)
                    ->fit(60, 50)->save($savePathXS);

          

           $savePathMD = $imagePathMD . $imageName;
           $image = Image::make($uploadedImage)
                    ->fit(480, 300)->save($savePathMD);

         return $imageName;           
    }
}