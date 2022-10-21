<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Movie;
use App\Helper\ApiResponse;
use App\Helper\SingleImageUpload;
use App\Interfaces\MovieInterface;

class MovieController extends Controller
{
    protected $movieInterface;
    use ApiResponse;
    use SingleImageUpload;

    public function __construct(MovieInterface $movieInterface)
    {
        $this->movieInterface = $movieInterface;
    }

    public function CreateNewMovieWithTags(Request $request)
    {

        //* Get multiple request input wich same name and wrapped it in array
        $tags = $request->collect('tags');

        $title = $request->input('title');
        $overview = $request->input('overview');
        $playUntil = $request->input('play_until');

        if (!$request->hasFile('poster')) {
            return $this->errorResponse('Sorry! you must upload an poster movie image', 400);
        }

        $validationRules = [
            'title' => 'required',
            'overview' => 'required',
            'play_until' => 'required',
            'tags' => 'required'
        ];
        $validationErrorMessage = [
            'title.required' => 'title input field must be required',
            'overview.required' => 'overview input field must be required',
            'play_until.required' => 'play_until input field must be required',
            'tags.required' => 'tags input field must be required',
        ];
        $validation = Validator::make($request->all(), $validationRules, $validationErrorMessage);
        if ($validation->fails()) {
            return $this->errorResponse($validation->errors(), 422);
        }

        
        list($image, $posterName) = $this->imageUpload($request, 'poster');

        $image->move('poster/', $posterName);
        $posterPath = '/public/poster/' . $posterName;

        $movie = new Movie;

        $movie->title = $title;
        $movie->overview = $overview;
        $movie->play_until = $playUntil;
        $movie->poster = $posterPath;

        list($newMovie, $error) = $this->movieInterface->CreateNewMovieWithTags($movie, $tags);
        if ($error != null) {
            return $this->errorResponse($error, 500);
        }

        return $this->successResponse($newMovie, 'Create new movie with tags successfully', 201);
    } 

    public function GetAllMovieWithTags()
    {
        list($movies, $error) = $this->movieInterface->GetAllMovieWithTags();
        if ($error != null) {
            return $this->errorResponse($error, 500);
        }

        return $this->successResponse($movies, 'Get all movie with tags successfully', 201);
    }

}
