<?php

namespace App\Http\Controllers\Api;

use App\Models\Statistics;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StatisticsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\StatisticsResource;
use App\Http\Requests\Api\UpdateStatisticsRequest;

class StatisticsController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = StatisticsResource::collection(Statistics::all());

        return $this->success($statistics, 'Statistics fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatisticsRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Statistics', 'public'); // Save in 'storage/app/public/Statisticss'
        }

        $Statistics = Statistics::create($validated);

        return $this->success(StatisticsResource::make($Statistics), 'Statistics created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Statistics $statistics)
    {
        return $this->success(StatisticsResource::make($statistics), 'Statistics fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatisticsRequest $request, Statistics $statistics)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($statistics->image) {
                Storage::disk('public')->delete($statistics->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Statistics', 'public');
        }

        $statistics->update($validated);

        return $this->success(StatisticsResource::make($statistics->refresh()), 'Statistics updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statistics $statistics)
    {
        $statistics->delete();

        return $this->success(null, 'Statistics deleted successfully', 200);
    }
}
