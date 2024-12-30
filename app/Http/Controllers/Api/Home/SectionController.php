<?php

namespace App\Http\Controllers\Api\Home;

use App\Models\Section;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SectionRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\SectionResource;
use App\Http\Requests\Api\UpdateSectionRequest;

class SectionController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = SectionResource::make(Section::first());

        return $this->success($section, 'Section fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Section', 'public'); // Save in 'storage/app/public/Sections'
        }

        $section = Section::create($validated);

        return $this->success(SectionResource::make($section), 'Section created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        return $this->success(SectionResource::make($section), 'Section fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request)
    {
        $section = Section::first();
        
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Section', 'public');
        }

        $section->update($validated);

        return $this->success(SectionResource::make($section->refresh()), 'Section updated successfully', 200);
    }

}
