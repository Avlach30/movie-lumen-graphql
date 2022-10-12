<?php

namespace App\Http\Controllers;

use DB;
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
        if (!$request->hasFile('poster')) {
            return $this->errorResponse('Sorry! you must upload an poster movie image', 400);
        }

        $this->validate($request, [
            'title' => 'required',
            'overview' => 'required',
            'play_until' => 'required',
            'tags' => 'required'
        ]);

        
        //* Get multiple request input wich same name and wrapped it in array
        $tags = $request->collect('tags');

        
        $image = $request->file('poster');

        $fileName = $image->getClientOriginalName();
        $fileExtension = $image->getClientOriginalExtension();
        $fileSize = $image->getSize();

        if (in_array($fileExtension, array("jpg", "jpeg", "png")) == false ) {
            return $this->errorResponse('Sorry! only image file is allowed', 400);
        }

        if ($fileSize > 1572864) {
            return $this->errorResponse('Sorry! only image file with size smaller than 1,5 Mb is allowed', 400);
        }

        $uuid = $this->attributes['uuid'] = Uuid::uuid4()->toString();
        $posterName = 'image-' . $uuid . '.' . $fileExtension;


        $image->move('poster/', $posterName);
        $posterPath = '/public/poster/' . $posterName;

        try {

            $movie = new Movie;

            $movie->title = $request->input('title');
            $movie->overview = $request->input('overview');
            $movie->play_until = $request->input('play_until');
            $movie->poster = $posterPath;

            $movie->save();

            
            
            foreach ($tags as $tag) {
                $newTag = new Tag;

                $newTag->name = $tag;

                $newTag->save();


                $movieTag = new MovieTag;

                $movieTag->movie_id = $movie->id;
                $movieTag->tag_id = $newTag->id;

                $movieTag->save();
            }

            DB::commit();

            return $this->successResponse($movie, 'Create new movie with tags successfully', 201);
            
        } catch (\Exception $exception) {
            DB::rollBack(); 

            return $this->errorResponse($exp->getMessage(), 400);
        }
    } 

}
