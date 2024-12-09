<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'gender', 'height', 'weight', 'age', 'is_pregnant',
        'pregnancy_week', 'pre_pregnancy_weight', 'delivery_date',
        'waist_circumference', 'hip_circumference', 'calf_circumference',
        'thigh_circumference', 'bust_circumference', 'wrist_circumference',
        'bicep_circumference', 'neck_circumference'
    ];
}
