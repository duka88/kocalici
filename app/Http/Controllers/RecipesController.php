<?php

namespace App\Http\Controllers;
use Session;
use App\Tag;
use App\Recipe;
use App\Category;
use App\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests\Recipe\CreateRecipeRequest;
use App\Http\Requests\Recipe\UpdateRecipeRequest;
use App\Http\Requests\Recipe\GalleryRequest;
use App\Http\Requests\Recipe\RecipeApiRequest;
use App\Http\Resources\GalleryResources;
use App\Http\Resources\IngredientsResources;
use App\Http\Resources\RecipeResources;
use App\Http\Resources\UsersRecipeResources;
use App\Http\Resources\SingleRecipeResources;
use Helper;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){

        $this->middleware('verifyCategoryCount')->only(['create', 'store']);
    }

    public function index()
    {
        return view('recipes.index')->with('recipes', Recipe::all())->with('tags', Tag::all());
    }

    public function delete($id){
      
       $recipe = Recipe::withTrashed()->where('id', $id)->firstOrFail();

      if($recipe->trashed()){
        $recipe->deleteImage();
        $recipe->forceDelete();
       
      } else{ 
        $recipe->delete();
        
       }

    }
   
    public function restore($id){
          

        $recipe = Recipe::onlyTrashed()->findOrFail($id)->restore();

         return Response('restored');

    }

    public function single($id){
         $recipe = Recipe::findOrFail($id);

        return Rsponse($recipe);
    }

    public function edit_recipe(UpdateRecipeRequest $request){    

   
      $recipe = Recipe::findOrFail($request->id);
    
      if($request->image['image']){
       $imageName = Helper::uploadImageSize($request->image['image'], $request->image['name']);
      }else{
        $imageName = $recipe->image;
      }
     
      $category = Category::where('name', $request->category)->first();

        $recipe->update([
           'title' =>$request->title,
           'slug' => str_slug($request->title),
           'description' => $request->description,
           'content' => $request->content,
           'time' => $request->time,
           'servings' => $request->servings,
           'dificulty' => $request->dificulty, 
           'image' => $imageName,                                 
           'category_id' => $category->id,
        ]);
       
      foreach($request->tags['tags'] as $tag){
            $tag = Tag::firstOrCreate([
                    'name' => $tag
                ]);
             }


      $tadsId = Tag::whereIn('name',$request->tags['tags'])
                  ->pluck('id');
            
            $sync_data = [];

        for($i = 0; $i < count($tadsId); $i++){
            
            $sync_data[$tadsId[$i]] = ['amount' => $request->tags['amount'][$i]];
            }
      
       $n = 0;
      foreach($request->gallery as $img){
        $n++;
        echo $n;
        if($n != 1){
          if($img['id'] == ''  && $img['image'] != ''){

             $galleryImage = Helper::uploadImageSize($img['image'], $img['name']); 

             $recipe->galleries()->create(['image' => $galleryImage]);
          }elseif($img['id'] != '' && $img['image'] != ''){
             $gallery = Gallery::findOrFail($img['id']);

             $galleryImage = Helper::uploadImageSize($img['image'], $img['name']);
              $gallery->update(['image' => $galleryImage]);   
          }
        }

      }       

      $recipe->tags()->sync($sync_data);  

        return Response($recipe);   
      
    }

    

  
    public function category($category, $order, $direction){
         
      $recipes = Recipe::searchCategory($category, $order, $direction);

        return RecipeResources::collection($recipes);
    }
   
   public function user_recipe($order, $direction, $search){
     

         $recipes = Recipe::user_recipes_order($order, $direction, $search);
          
          return UsersRecipeResources::collection($recipes);

   }



    public function stored(RecipeApiRequest $request){
           
          $user_id = auth()->user()->id;

           $galleries = [];
            foreach( $request->gallery as $image){

             if($image['image'] != false){
                 $imageName = Helper::uploadImageSize($image['image'], $image['name']);

                  array_push($galleries, $imageName);
                  }
               }
             
              $recipe = Recipe::create([
                    'title' =>$request->title,
                    'slug' => str_slug($request->title),
                    'description' => $request->description,
                    'content' => $request->content,
                    'time' => $request->time,
                    'servings' => $request->servings,
                    'dificulty' => $request->dificulty, 
                    'image' => $galleries[0],
                    'user_id' => $user_id,              
                    'category_id' =>  $request->category_id,
                 ]);
              
              $i = 0;

              foreach($galleries as $gallery){
                 $i++;
               if($i == 1) {
                  continue;
               }else{
                 $recipe->galleries()->create([
                 'image' => $gallery
                   ]);
                 }
             }

             
             foreach($request->tags as $tag){
                $tag = Tag::firstOrCreate([
                    'name' => $tag
                ]);
             }
             
            $tadsId = Tag::whereIn('name', $request->tags)->pluck('id');
            
            $sync_data = [];

            for($i = 0; $i < count($tadsId); $i++){
            
            $sync_data[$tadsId[$i]] = ['amount' => $request->amount[$i]];
            }

              $recipe->tags()->sync($sync_data);


             return Response($recipe);
    }

    public function ingredients($id){
      
       $ingredients = Recipe::findOrFail($id);

       return new IngredientsResources($ingredients);
    }

    public function search($search, $category, $order, $direction){
        
      $recipes = Recipe::search($search, $category, $order, $direction);

       return RecipeResources::collection($recipes);
   
    }

    public function all_recipe( $order, $direction, $search){

       $recipes = Recipe::all_recipes( $order, $direction, $search);

       return UsersRecipeResources::collection($recipes);    

      }
   public function trash( $order, $direction, $search){

       $recipes = Recipe::trash( $order, $direction, $search);

       return UsersRecipeResources::collection($recipes);    

      }
       
}
