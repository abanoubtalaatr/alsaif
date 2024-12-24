<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\Training;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\BlogResource;
use App\Http\Requests\Api\TrainingRequest;
use App\Http\Requests\Api\UpdateBlogRequest;
use App\Http\Requests\Api\UpdateTrainingRequest;
use App\Http\Resources\Api\TrainingResource;

class TrainingController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainings = TrainingResource::collection(Training::all());

        return $this->success($trainings, 'trainings fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('trainings', 'public'); // Save in 'storage/app/public/blogs'
        }

        $training = Training::create($validated);

        return $this->success(TrainingResource::make($training), 'training created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Training $training)
    {
        return $this->success(TrainingResource::make($training), 'Training fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainingRequest $request, Training $training)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($training->image) {
                Storage::disk('public')->delete($training->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('training', 'public');
        }

        $training->update($validated);

        return $this->success(TrainingResource::make($training->refresh()), 'Training updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training)
    {
        $training->delete();

        return $this->success(null, 'training deleted successfully', 200);
    }
}
