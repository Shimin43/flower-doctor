<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'scientific_name',
        'local_name',
        'description',
        'characteristics',
        'colors',
        'growing_conditions',
        'care_guide',
        'uses',
        'image_path',
        'is_active',

        // Market value information
        'market_value',
        'market_value_unit',
        'market_value_location',
        'market_value_updated_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'market_value' => 'decimal:2',
        'market_value_updated_at' => 'date:Y-m-d',
    ];
}
