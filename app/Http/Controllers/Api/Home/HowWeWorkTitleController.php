<?php

namespace App\Http\Controllers\Api\Home;

use App\Models\Section;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HowWeWorkTitleRequest;
use App\Http\Requests\Api\SectionRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\SectionResource;
use App\Http\Requests\Api\UpdateSectionRequest;
use App\Http\Resources\Api\HowWeWorkTitleResource;
use App\Models\HowWeWorkTitle;

class HowWeWorkTitleController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $howWeWorkTitle = HowWeWorkTitle::make(HowWeWorkTitle::first());

        return $this->success($howWeWorkTitle, 'How we work title fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HowWeWorkTitleRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('HowWeWorkTitle', 'public'); // Save in 'storage/app/public/Sections'
        }

        $howWeWorkTitle = HowWeWorkTitle::create($validated);

        return $this->success(SectionResource::make($howWeWorkTitle), 'howWeWorkTitle created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(HowWeWorkTitle $howWeWorkTitle)
    {
        return $this->success(HowWeWorkTitleResource::make($howWeWorkTitle), 'how we work title fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HowWeWorkTitleRequest $request)
    {
        $howWeWorkTitle = HowWeWorkTitle::first();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($howWeWorkTitle->image) {
                Storage::disk('public')->delete($howWeWorkTitle->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('HowWeWorkTitle', 'public');
        }

        $howWeWorkTitle->update($validated);

        return $this->success(HowWeWorkTitleResource::make($howWeWorkTitle->refresh()), 'how we work title updated successfully', 200);
    }

}
