<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'studio_number', 'seat_capacity'
    ];
    
    /**
     * @var bool
     */

    public $timestamps = true;

    /**
     *
     * @var string
     */

    protected $table = 'studios';
}
