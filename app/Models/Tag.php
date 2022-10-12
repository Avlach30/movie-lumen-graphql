<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @var bool
     */

    public $timestamps = true;

    /**
     *
     * @var string
     */

    protected $table = 'tags';
}
