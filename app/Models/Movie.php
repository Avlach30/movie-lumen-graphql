<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'title', 'overview', 'poster', 'play_until'
    ];

    /**
     * @var bool
     */

    public $timestamps = true;

    /**
     *
     * @var string
     */

    protected $table = 'movies';

}
