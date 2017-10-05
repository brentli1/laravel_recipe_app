<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Recipe;
use App\Image;
use App\Http\Resources\Recipe as RecipeResource;

class RecipeController extends Controller
{
    public function getRecipes() {
        $recipes = Recipe::where('user_id', Auth::User()->id)->orderBy('created_at', 'desc')->get();

        return RecipeResource::collection($recipes);
    }

    public function getRecipe($id) {
        $recipe = Recipe::find($id);
        if ($recipe->user_id !== Auth::User()->id) return;

        return new RecipeResource($recipe);
    }

    public function new(Request $request) {
        $recipe = new Recipe();

        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        Auth::User()->recipes()->save($recipe);
        $recipe->save();

        return new RecipeResource($recipe);
    }

    public function update(Request $request, $id) {
        $recipe = Recipe::find($id);

        if ($recipe->user_id !== Auth::User()->id) return;

        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        $recipe->save();

        if ($request->hasFile('image')) {
            $this->saveImage($recipe, $request->image);
            $recipe->load('image');
        }
    
        return new RecipeResource($recipe);
    }

    public function saveImage($recipe, $image) {
        $img = count($recipe->image) == 0 ? new Image() : Image::find($recipe->image[0]->id);
        $image_path = $image->store('recipes');

        $img->path = $image_path;
        $img->name = $image->getClientOriginalName();
        $img->save();

        if (count($recipe->image) !== 0) {
            Storage::delete($recipe->image[0]->path);
        } else {
            $recipe->image()->attach($img);
        }
    }
}
