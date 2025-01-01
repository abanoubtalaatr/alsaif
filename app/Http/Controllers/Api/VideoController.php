<?php

namespace App\Http\Controllers\Api;

use App\Models\AboutUs;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AboutUsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\AboutUsResource;
use App\Http\Requests\Api\UpdateAboutUsRequest;
use App\Http\Requests\Api\UpdateVideoRequest;
use App\Http\Resources\Api\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $video = VideoResource::make(Video::first());

        return $this->success($video, 'video fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('video')) {
            $validated['video'] = $request->file('video')->store('video', 'public');
        }

        $video = Video::create($validated);

        return $this->success(VideoResource::make($video), 'video created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return $this->success(VideoResource::make($video), 'video fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request)
    {
        $video = Video::first();

        $validated = $request->validated();

        if ($request->hasFile('video')) {
            // Delete the old image if it exists
            if ($video->video) {
                Storage::disk('public')->delete($video->video);
            }

            // Save the new image
            $validated['video'] = $request->file('video')->store('video', 'public');
        }

        $video->update($validated);

        return $this->success(VideoResource::make($video->refresh()), 'video updated successfully', 200);
    }

}
