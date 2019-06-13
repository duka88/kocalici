<?php 
namespace App\Http;

use Intervention\Image\Facades\Image;

class Helper{

	public static function uploadImageSize($uploadedImage, $uploadedImageName=null){

        $imagePathXS = public_path('img/XS/');
        $imagePathMD = public_path('img/MD/');
        $imagePathS = public_path('img/S/');
          
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
                    ->fit(480, 480)->save($savePathMD);

           $savePathS = $imagePathS . $imageName;
           $image = Image::make($uploadedImage)
                    ->fit(100, 100)->save($savePathS);         

         return $imageName;           
    }
}