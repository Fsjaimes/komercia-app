<?php

namespace App\Http\Controllers\Beauty;

use App\Http\Controllers\Controller;
use App\Models\Beauty\Appointment;
use App\Models\Beauty\Client;
use App\Models\Beauty\Service;
use App\Models\Beauty\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $appointments = Appointment::with(['client', 'services.service', 'services.staff'])
            ->whereDate('scheduled_at', $date)
            ->orderBy('scheduled_at')
            ->paginate(10);

        return Inertia::render('Beauty/Appointments/Index', compact('appointments', 'date'));
    }

    public function create()
    {
        $clients = Client::all();
        $services = Service::where('active', true)->get();
        $staff = Staff::all();
        return Inertia::render('Beauty/Appointments/Create', compact('clients', 'services', 'staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:beauty_clients,id',
            'scheduled_at' => 'required|date_format:Y-m-d\TH:i',
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:beauty_services,id',
            'services.*.staff_id' => 'nullable|exists:beauty_staff,id',
        ]);

        $services = Service::whereIn('id', collect($request->services)->pluck('service_id'))->get();
        $totalDuration = $services->sum('duration_minutes');
        $totalPrice = $services->sum('price');

        $appointment = Appointment::create([
            'client_id' => $request->client_id,
            'scheduled_at' => $request->scheduled_at,
            'total_duration_minutes' => $totalDuration,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        foreach ($request->services as $item) {
            $appointment->services()->create([
                'service_id' => $item['service_id'],
                'staff_id' => $item['staff_id'] ?? null,
            ]);
        }

        return redirect()->route('beauty.appointments.index')->with('success', 'Cita agendada.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['client', 'services.service', 'services.staff', 'payment']);
        return Inertia::render('Beauty/Appointments/Show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $clients = Client::all();
        $services = Service::where('active', true)->get();
        $staff = Staff::all();
        $appointment->load('services');
        return Inertia::render('Beauty/Appointments/Edit', compact('appointment', 'clients', 'services', 'staff'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'client_id' => 'required|exists:beauty_clients,id',
            'scheduled_at' => 'required|date_format:Y-m-d\TH:i',
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:beauty_services,id',
            'services.*.staff_id' => 'nullable|exists:beauty_staff,id',
        ]);

        $services = Service::whereIn('id', collect($request->services)->pluck('service_id'))->get();
        $totalDuration = $services->sum('duration_minutes');
        $totalPrice = $services->sum('price');

        $appointment->update([
            'client_id' => $request->client_id,
            'scheduled_at' => $request->scheduled_at,
            'total_duration_minutes' => $totalDuration,
            'total_price' => $totalPrice,
        ]);

        $appointment->services()->delete();
        foreach ($request->services as $item) {
            $appointment->services()->create([
                'service_id' => $item['service_id'],
                'staff_id' => $item['staff_id'] ?? null,
            ]);
        }

        return redirect()->route('beauty.appointments.show', $appointment->id)->with('success', 'Cita actualizada.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('beauty.appointments.index')->with('success', 'Cita cancelada.');
    }
}