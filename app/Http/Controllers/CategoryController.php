<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App\Category;

/**
 * Category Controller
 * 
 * PHP version 7.1.9
 */
class CategoryController extends Controller
{
    /**
     * Fetch all categories and return their names
     * 
     * @return array
     */
    public function getCategories() {
        // return array(Category::pluck('name'));
        return CategoryResource::collection(Category::all());
    }

    /**
     * Add new category
     *
     * @param array $category The category data
     * @return App\Category
     **/
    public function create($catData)
    {
        $this->validateCategory($catData);

        $category = new Category();
        $category = $this->saveCategoryValues($category, $catData);

        return $category;
    }

    /**
     * Validates the category
     *
     * @param App\Category $category The category data
     * @return void
     **/
    public function validateCategory($category)
    {
        $this->validate($category, [
            'name' => 'required|unique:categories'
        ]);
    }

    /**
     * Save Category values.
     *
     * @param  App\Category $category
     * @param  array $catData
     * @return App\Category
     */
    private function saveCategoryValues($category, $catData) {
        $category->name = $catData->name;
        $category->save();

        return $category;
    }
}
