<?php

namespace App\Models\Beauty;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'beauty_services';
    protected $fillable = ['name', 'description', 'duration_minutes', 'price', 'category', 'active'];
}