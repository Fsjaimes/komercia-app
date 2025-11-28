<?php

namespace App\Models\Beauty;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'beauty_payments';
    protected $fillable = ['appointment_id', 'amount', 'method'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}