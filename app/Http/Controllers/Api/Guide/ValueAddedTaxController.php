<?php

namespace App\Http\Controllers\Api\Guide;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\ValueAddedTax;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\Guide\ValueAddedTaxRequest;
use App\Http\Resources\Api\Guide\ValueAddedTaxResource;
use App\Http\Requests\Api\Guide\UpdateValueAddedTaxRequest;

class ValueAddedTaxController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $valueAddedTax = ValueAddedTaxResource::make(ValueAddedTax::first());

        return $this->success($valueAddedTax, 'ValueAddedTaxs fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValueAddedTaxRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ValueAddedTaxes', 'public');
        }

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('ValueAddedTaxes', 'public');
        }

        $valueAddedTax = ValueAddedTax::create($validated);

        return $this->success(ValueAddedTaxResource::make($valueAddedTax), 'ValueAddedTax created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(ValueAddedTax $value_added_tax)
    {
        return $this->success(ValueAddedTaxResource::make($value_added_tax), 'ValueAddedTax fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateValueAddedTaxRequest $request)
    {
        $value_added_tax = ValueAddedTax::first();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($value_added_tax->image) {
                Storage::disk('public')->delete($value_added_tax->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('ValueAddedTaxes', 'public');
        }

        if ($request->hasFile('file')) {
            // Delete the old image if it exists
            if ($value_added_tax->image) {
                Storage::disk('public')->delete($value_added_tax->file);
            }

            // Save the new image
            $validated['file'] = $request->file('file')->store('ValueAddedTaxes', 'public');
        }

        $value_added_tax->update($validated);

        return $this->success(ValueAddedTaxResource::make($value_added_tax->refresh()), 'ValueAddedTax updated successfully', 200);
    }

}
