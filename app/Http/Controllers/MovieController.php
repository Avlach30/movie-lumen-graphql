<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\Movie;
use App\Models\Tag;
use App\Models\MovieTag;
use App\Helper\ApiResponse;

class MovieController extends Controller
{
    use ApiResponse;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'SignUp']]);
    }

    public function CreateNewMovieWithTags(Request $request)
    {
        
        
    } 

}
