<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Recipe;
use App\Image;
use App\Category;
use App\Http\Resources\Recipe as RecipeResource;
use App\Traits\SaveImageTrait;

/**
 * Recipe Controller
 * 
 * PHP version 7.1.9
 */
class RecipeController extends Controller
{
    use SaveImageTrait;

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

        // Sync the categories in the request to the recipe 
        $recipe->categories()->sync(array_column(json_decode($request->categories), 'id'));

        if ($request->hasFile('image')) {
            $this->saveImage($recipe, $request->image);
            $recipe->load('image');
        }
        
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

        // Sync the categories in the request to the recipe 
        $recipe->categories()->sync(array_column(json_decode($request->categories), 'id'));
        
        if ($request->hasFile('image')) {
            $this->saveImage($recipe, $request->image);
            $recipe->load('image');
        }
        
        return new RecipeResource($recipe);
    }
}
