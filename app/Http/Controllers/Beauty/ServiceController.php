<?php

namespace App\Http\Controllers\Beauty;

use App\Http\Controllers\Controller;
use App\Models\Beauty\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(10);
        return Inertia::render('Beauty/Services/Index', compact('services'));
    }

    public function create()
    {
        return Inertia::render('Beauty/Services/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
        ]);

        Service::create($request->all());
        return redirect()->route('beauty.services.index')->with('success', 'Servicio creado.');
    }

    public function edit(Service $service)
    {
        return Inertia::render('Beauty/Services/Edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:5',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
        ]);

        $service->update($request->all());
        return redirect()->route('beauty.services.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('beauty.services.index')->with('success', 'Servicio eliminado.');
    }
}