<?php

namespace App\Repositories;

use DB;

use App\Interfaces\MovieInterface;
use App\Models\Movie;
use App\Models\MovieTag;
use App\Models\Tag;

class MovieRepository implements MovieInterface
{

    public function CreateNewMovieWithTags(Movie $movie, $tags)
    {
        try {
            DB::beginTransaction();

            $newMovie = $movie->save();

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

            return [$movie, null];
        } catch (\Exception $exception) {
            DB::rollBack(); 

            return [$movie, 'Create new movie with tags failed'];
        }
    }

    public function GetAllMovieWithTags()
    {
        try {
            $movies = Movie::with('tags')->get();

            return [$movies, null];
        } catch (\Exception $exception) {
            return [$movies, 'Get all movies with tags failed'];
        }
    }
}
