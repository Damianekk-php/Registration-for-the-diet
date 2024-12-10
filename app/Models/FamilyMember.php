<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'family';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'status',
    ];
}
