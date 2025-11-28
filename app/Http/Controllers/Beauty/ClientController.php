<?php

namespace App\Http\Controllers\Beauty;

use App\Http\Controllers\Controller;
use App\Models\Beauty\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Client::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('document', 'like', "%{$search}%");
            });
        }
        $clients = $query->paginate(10);
        return Inertia::render('Beauty/Clients/Index', [
            'clients' => $clients,
            'search' => $search
        ]);
    }

    public function create()
    {
        return Inertia::render('Beauty/Clients/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|unique:beauty_clients',
            'document' => 'required|unique:beauty_clients',
            'email' => 'nullable|email|unique:beauty_clients',
        ]);

        Client::create($request->all());
        return redirect()->route('beauty.clients.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit(Client $client)
    {
        return Inertia::render('Beauty/Clients/Edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|unique:beauty_clients,phone,' . $client->id,
            'document' => 'required|unique:beauty_clients,document,' . $client->id,
            'email' => 'nullable|email|unique:beauty_clients,email,' . $client->id,
        ]);

        $client->update($request->all());
        return redirect()->route('beauty.clients.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('beauty.clients.index')->with('success', 'Cliente eliminado.');
    }
}