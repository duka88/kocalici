<?php

namespace App\Http\Controllers;
use Session;
use App\Tag;
use App\Recipe;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Recipe\CreateRecipeRequest;
use App\Http\Requests\Recipe\UpdateRecipeRequest;


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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRecipeRequest $request)
    {
        $image = $request->image->store('recipes');

        $recipe = Recipe::create([
          'title' =>$request->title,
          'description' => $request->description,
          'content' =>$request->content,
          'image' => $image,
          'user_id' => auth()->user()->id,
          'published_at' => $request->published_at,
          'category_id' =>  $request->category
        ]);

        $recipe->tags()->attach($request->tags);

        session()->flash('success', 'Recipe created');

        return redirect(route('recipe.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        return view('recipes.create')->with('recipe', $recipe)->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $data = $request->only(['title', 'description', 'published_at', 'content','category_id']);

        if($request->hasFile('image')){
          $image = $request->image->store('recipe');

          $recipe->deleteImage();
          $data['image'] = $image;
        }

        if($request->tags){
            $recipe->tags()->sync($request->tags);
        }

        $recipe->update($data);

        session()->flash('success', 'Recipe updated');

        return redirect(route('recipe.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
