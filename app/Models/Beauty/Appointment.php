<?php

namespace App\Models\Beauty;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'beauty_appointments';
    protected $fillable = ['client_id', 'scheduled_at', 'total_duration_minutes', 'total_price', 'status', 'notes'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function services()
    {
        return $this->hasMany(AppointmentService::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}