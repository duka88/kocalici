<?php

namespace App\Http\Controllers;
use Session;
use App\Tag;
use App\Recipe;
use App\Category;
use App\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\Recipe\CreateRecipeRequest;
use App\Http\Requests\Recipe\UpdateRecipeRequest;
use App\Http\Requests\Recipe\GalleryRequest;
use App\Http\Requests\Recipe\RecipeApiRequest;
use App\Http\Resources\GalleryResources;
use App\Http\Resources\IngredientsResources;
use App\Http\Resources\RecipeResources;
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

 
   
    public function destroy($id)
    {

      $recipe = Recipe::withTrashed()->where('id', $id)->firstOrFail();

      if($recipe->trashed()){
        $recipe->deleteImage();
        $recipe->forceDelete();
        session()->flash('success', 'Recipe is trashed');
      } else{ 
        $recipe->delete();
        session()->flash('success', 'Recipe is trashed');
       }

        

        return redirect(route('recipe.index'));

    }

    public function trashed(){

        $trashed = Recipe::onlyTrashed()->get();

        return view('recipes.index')->withRecipes($trashed); ///ja isto kao >with('recipes',$trashed)
    }

    public function restore($id){

        $recipe = Recipe::withTrashed()->where('id' , $id)->firstOrFail();  

        $recipe->restore();

        session()->flash('success', 'Post restored');

        return redirect()->back();
    }

    public function category($id){
         
        if($id != 0){
        $recipes = Recipe::where('category_id', $id)->latest()->paginate(6);
      }else{
        $recipes = Recipe::latest()->paginate(6);

        }

        return RecipeResources::collection($recipes);
    }
   
   public function user_recipe($id){

        $recipes = Recipe::where('user_id', $id)->latest()->paginate(6);

        return RecipeResources::collection($recipes);
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


             return Response($request);
    }

    public function ingredients($id){
      
       $ingredients = Recipe::findOrFail($id);

       return new IngredientsResources($ingredients);
    }

    public function search($search, $category, $order, $direction){
        
      


       if($category != 0){
          if($order == 'score'){
           $recipes = Recipe::where('title', 'LIKE', "%$search%")
                       ->where('category_id', $category)
                       ->withCount(['scores as average' => function ($q){
                        $q->select(DB::raw('coalesce(avg(score), 0)'));
                      }])->orderBy('average' ,$direction)->paginate(9); 
         }elseif($order == 'likes'){
             $recipes = Recipe::where('title', 'LIKE', "%$search%")
                       ->where('category_id', $category)
                       ->withCount('likes')
                       ->orderBy('likes_count', $direction)->paginate(9);  
          }else{
            $recipes = Recipe::where('title', 'LIKE', "%$search%")
                       ->where('category_id', $category)
                       ->orderBy($order, $direction)->paginate(9);
          }


       }else{
          
           if($order == 'score'){
               $recipes = Recipe::where('title', 'LIKE', "%$search%")
                           
                           ->withCount(['scores as average' => function ($q){
                            $q->select(DB::raw('coalesce(avg(score), 0)'));
                          }])->orderBy('average' ,$direction)->paginate(9); 
             }elseif($order == 'likes'){
                 $recipes = Recipe::where('title', 'LIKE', "%$search%")
                           
                           ->withCount('likes')
                           ->orderBy('likes_count', $direction)->paginate(9);  
              }else{
                $recipes = Recipe::where('title', 'LIKE', "%$search%")
                           
                           ->orderBy($order, $direction)->paginate(9);
              }

           
       }
       
   

              return RecipeResources::collection($recipes);

   
    }
       
}
