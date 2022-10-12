<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieTag extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'movie_id', 'tag_id'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'foreign_key');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'foreign_key');
    }

    /**
     * @var bool
     */

    public $timestamps = true;

    /**
     *
     * @var string
     */

    protected $table = 'movie_tags';
}
