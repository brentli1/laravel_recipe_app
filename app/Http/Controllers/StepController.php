<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\Step;
use App\Image;
use App\Http\Resources\Recipe as RecipeResource;
use App\Traits\SaveImageTrait;

/**
 * Step Controller
 * 
 * PHP version 7.1.9
 */
class StepController extends Controller
{
    use SaveImageTrait;

    /**
     * Create a new step for a recipe
     *
     * @param Illuminate\Http\Request $request The request data
     * @param int $id The id of the recipe
     * @return array
     **/
    public function create(Request $request, $id)
    {
        $recipe = Recipe::find($id);
        $step = new Step();

        $step->body = $request->body;
        $step->order = count($recipe->steps) + 1;
        $recipe->steps()->save($step);

        if ($request->hasFile('image')) {
            $this->saveImage($step, $request->image);
            $step->load('image');
        }
        
        $recipe->load('steps');

        return new RecipeResource($recipe);
    }
}
