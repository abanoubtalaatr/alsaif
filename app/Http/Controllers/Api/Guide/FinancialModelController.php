<?php

namespace App\Http\Controllers\Api\Guide;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\FinancialModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\Guide\FinancialModelRequest;
use App\Http\Resources\Api\Guide\FinancialModelResource;
use App\Http\Requests\Api\Guide\UpdateFinancialModelRequest;

class FinancialModelController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $FinancialModels = FinancialModelResource::collection(FinancialModel::all());

        return $this->success($FinancialModels, 'FinancialModels fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FinancialModelRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('FinancialModels', 'public');
        }
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('FinancialModels', 'public');
        }

        $FinancialModel = FinancialModel::create($validated);

        return $this->success(FinancialModelResource::make($FinancialModel), 'FinancialModel created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(FinancialModel $financial_model)
    {
        return $this->success(FinancialModelResource::make($financial_model), 'FinancialModel fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinancialModelRequest $request, FinancialModel $financial_model)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($financial_model->image) {
                Storage::disk('public')->delete($financial_model->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('FinancialModels', 'public');
        }

        if ($request->hasFile('file')) {
            // Delete the old image if it exists
            if ($financial_model->image) {
                Storage::disk('public')->delete($financial_model->file);
            }

            // Save the new image
            $validated['file'] = $request->file('file')->store('FinancialModels', 'public');
        }

        $financial_model->update($validated);

        return $this->success(FinancialModelResource::make($financial_model->refresh()), 'FinancialModel updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialModel $financial_model)
    {
        $financial_model->delete();

        return $this->success(null, 'FinancialModel deleted successfully', 200);
    }
}
