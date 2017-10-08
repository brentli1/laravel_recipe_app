<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Recipe;
use App\Image;
use App\Http\Resources\Recipe as RecipeResource;

/**
 * Recipe Controller
 * 
 * PHP version 7.1.9
 */
class RecipeController extends Controller
{
    /**
     * Get all recipes matching current user ID
     * 
     * @return array
     */
    public function getRecipes() {
        $recipes = Recipe::where('user_id', Auth::User()->id)->orderBy('created_at', 'desc')->get();

        return RecipeResource::collection($recipes);
    }

    /**
     * Get recipe matching request ID
     * 
     * @param int $id The id of the requested recipe
     * @return array
     */
    public function getRecipe($id) {
        $recipe = Recipe::find($id);
        if ($recipe->user_id !== Auth::User()->id) return;

        return new RecipeResource($recipe);
    }

    /**
     * Create new recipe using request data
     * 
     * @params Illuminate\Http\Request $request The request data
     * @return array
     */
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

    /**
     * Update requested recipe
     * 
     * @param Illuminate\Http\Request $request The request data
     * @param int $id The id of the recipe to be updated
     * @return array
     */
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

    /**
     * Save image for recipe
     * 
     * @param App\Recipe $recipe The recipe
     * @param App\Image $image The image for the recipe
     * @return void
     */
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
