<?php

namespace App\Models\Beauty;

use Illuminate\Database\Eloquent\Model;

class AppointmentService extends Model
{
    protected $table = 'beauty_appointment_services';
    protected $fillable = ['appointment_id', 'service_id', 'staff_id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}