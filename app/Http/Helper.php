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


    public static function Rating($min, $max, $avg){

      $star = "";
        for ($i = $min; $i <= $max; $i+=2){
                if($avg > 1){
                  $star .= '<i class="fas fa-star"></i>';
                 $avg -= 2;
                }elseif($avg > 0.5) {  
                  $star .= ' <i class="fas fa-star-half-alt"></i>';
                 $avg -= 2;
              }else { 
                 $star .= '<i class="far fa-star"></i>';
              }
            }

            return $star;
         }
            
}