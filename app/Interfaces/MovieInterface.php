<?php

namespace App\Interfaces;

use App\Models\Movie;

interface MovieInterface
{
    public function CreateNewMovieWithTags(Movie $movie, $tags);

    public function GetAllMovieWithTags();
}