<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\Gallery;
use App\Http\Resources\GalleryResources;
use App\Http\Requests\Recipe\GalleryRequest;
use Helper;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
         $gallery = Gallery::where('recipe_id', $id)->get();

        return GalleryResources::collection($gallery);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
          $imageName = Helper::uploadImageSize($request->image, $request->name);

         $gallery = Gallery::create([
            'image' => $imageName
         ]);

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
    public function edit(GalleryRequest $request)
    {
        $gallery = Gallery::findOrFail($request->id);
      
      if(isset($request->image)) {
           $imageName = Helper::uploadImageSize($request->image, $request->name);
           $gallery->image = $imageName;
        }
      if(isset($reguest->recipe_id)){
           $gallery->recipe_id = $reguest->recipe_id;
      }  

         

        $gallery->save();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}



         
 