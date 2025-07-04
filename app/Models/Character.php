<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'api_id',
        'name',
        'status',
        'species',
        'type',
        'gender',
        'origin_name',
        'origin_url',
        'image',
    ];
}
