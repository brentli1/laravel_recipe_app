<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function fetchUser() {
    	return new UserResource(Auth::User());
    }
}
