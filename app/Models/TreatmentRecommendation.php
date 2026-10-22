<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'flower_species',
        'disease_name',
        'symptoms',
        'cause',
        'prevention',
        'treatment',
        'farmer_advice',
        'treatment_type',
        'safety_precautions',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
