<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Resources\User as UserResource;

/**
 * User Controller
 * 
 * PHP version 7.1.9
 */
class UserController extends Controller
{
    /**
     * Fetch the current user
     * 
     * @return array
     */
    public function fetchUser() {
    	return new UserResource(Auth::User());
    }
}
