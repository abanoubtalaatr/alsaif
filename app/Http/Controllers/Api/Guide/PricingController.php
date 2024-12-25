<?php

namespace App\Http\Controllers\Api\Guide;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Pricing;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\Guide\PricingRequest;
use App\Http\Resources\Api\Guide\PricingResource;
use App\Http\Requests\Api\Guide\UpdatePricingRequest;

class PricingController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pricings = PricingResource::collection(Pricing::all());

        return $this->success($pricings, 'Pricings fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PricingRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Pricings', 'public');
        }

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('Pricings', 'public');
        }

        $pricing = Pricing::create($validated);

        return $this->success(PricingResource::make($pricing), 'Pricing created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Pricing $pricing)
    {
        return $this->success(PricingResource::make($pricing), 'Pricing fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePricingRequest $request, Pricing $pricing)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($pricing->image) {
                Storage::disk('public')->delete($pricing->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Pricings', 'public');
        }

        if ($request->hasFile('file')) {
            // Delete the old image if it exists
            if ($pricing->image) {
                Storage::disk('public')->delete($pricing->file);
            }

            // Save the new image
            $validated['file'] = $request->file('file')->store('Pricings', 'public');
        }

        $pricing->update($validated);

        return $this->success(PricingResource::make($pricing->refresh()), 'Pricing updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pricing $pricing)
    {
        $pricing->delete();

        return $this->success(null, 'Pricing deleted successfully', 200);
    }
}
