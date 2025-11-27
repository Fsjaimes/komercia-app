<?php

namespace App\Models\Beauty;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'beauty_staff';
    protected $fillable = ['name', 'phone', 'email'];
}