<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Resources\CategoryResources;
use Illuminate\Http\Request;
use App\Category;
use Helper;
use Session;
use Illuminate\Support\Str;
class CategoriesController extends Controller
{
	
	public function index()
	{
	   return view('categories.index')->with('categories', Category::all());
	}

	public function store(CreateCategoryRequest $request)
	{
	  if($request->image['image']){
        $imageName = Helper::uploadImageSize($request->image['image'], $request->image['name']);
       }

		$category = Category::create([
		  'name' => $request->name,
		  'slug' =>  Str::slug($request->name),
		  'image' => $imageName
		]);

		return new CategoryResources($category);
	}


	public function show()
	{
		$categories = Category::all();

		return CategoryResources::collection($categories);
	}

	
	public function update(CreateCategoryRequest $request)
	{
		$category = Category::findOrFail($request->id);

		if($request->image['image']){
       $imageName = Helper::uploadImageSize($request->image['image'], $request->image['name']);

        	$category->update([			
			'image' => $imageName
		]);
       }

		$category->update([
			'name' => $request->name
			
		]);


			return new CategoryResources($category);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{

        $category = Category::findOrFail($id);

		if($category->recipes->count() > 0){
			
			return response()->json("cen't delete category while have recipes", 422);
                
		}

		$category->delete();

		return new CategoryResources($category);
	}
}
