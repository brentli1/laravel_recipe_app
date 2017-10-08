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
        return array(Category::pluck('name'));
    }
}
