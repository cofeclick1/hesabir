<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'code',
        'type',
        'parent_id',
        'description',
        'image',
        'active',
        'person_type',
        'unit',
        'tax',
        'service_type',
        'base_rate',
    ];
}
