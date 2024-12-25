<?php

namespace App\Http\Controllers\Api;

use App\Models\AboutUs;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AboutUsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\AboutUsResource;
use App\Http\Requests\Api\UpdateAboutUsRequest;

class AboutUsController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $AboutUs = AboutUsResource::make(AboutUs::first());

        return $this->success($AboutUs, 'AboutUs fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutUsRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('AboutUs', 'public'); // Save in 'storage/app/public/AboutUss'
        }

        $AboutUs = AboutUs::create($validated);

        return $this->success(AboutUsResource::make($AboutUs), 'AboutUs created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(AboutUs $about_u)
    {
        return $this->success(AboutUsResource::make($about_u), 'AboutUs fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutUsRequest $request)
    {
        $about_u = AboutUs::first();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($about_u->image) {
                Storage::disk('public')->delete($about_u->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('AboutUs', 'public');
        }

        $about_u->update($validated);

        return $this->success(AboutUsResource::make($about_u->refresh()), 'AboutUs updated successfully', 200);
    }

}
