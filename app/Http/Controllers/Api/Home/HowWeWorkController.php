<?php

namespace App\Http\Controllers\Api\Home;

use App\Models\HowWeWork;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Home\HowWeWorkRequest;
use App\Http\Requests\Api\Home\UpdateHowWeWorkRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\Home\HowWeWorkResource;

class HowWeWorkController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $howWeWorks = HowWeWorkResource::collection(HowWeWork::all());

        return $this->success($howWeWorks, 'HowWeWorks fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HowWeWorkRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('HowWeWorks', 'public'); // Save in 'storage/app/public/HowWeWorks'
        }

        $howWeWork = HowWeWork::create($validated);

        return $this->success(HowWeWorkResource::make($howWeWork), 'HowWeWork created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(HowWeWork $how_we_work)
    {
        return $this->success(HowWeWorkResource::make($how_we_work), 'HowWeWork fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHowWeWorkRequest $request, HowWeWork $how_we_work)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($how_we_work->image) {
                Storage::disk('public')->delete($how_we_work->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('HowWeWorks', 'public');
        }

        $how_we_work->update($validated);

        return $this->success(HowWeWorkResource::make($how_we_work->refresh()), 'HowWeWork updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HowWeWork $how_we_work)
    {
        $how_we_work->delete();

        return $this->success(null, 'HowWeWork deleted successfully', 200);
    }
}
