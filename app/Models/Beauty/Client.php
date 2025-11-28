<?php

namespace App\Models\Beauty;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'beauty_clients';
    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'alias', 'document'];
}