<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClientRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\ClientResource;
use App\Http\Requests\Api\UpdateClientRequest;

class ClientController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = ClientResource::collection(Client::all());

        return $this->success($clients, 'Clients fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Clients', 'public'); // Save in 'storage/app/public/Clients'
        }

        $client = Client::create($validated);

        return $this->success(ClientResource::make($client), 'Client created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Client $Client)
    {
        return $this->success(ClientResource::make($Client), 'Client fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($client->image) {
                Storage::disk('public')->delete($client->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Clients', 'public');
        }

        $client->update($validated);

        return $this->success(ClientResource::make($client->refresh()), 'Client updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return $this->success(null, 'Client deleted successfully', 200);
    }
}
