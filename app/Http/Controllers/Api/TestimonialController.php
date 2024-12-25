<?php

namespace App\Http\Controllers\Api;

use App\Models\Testimonial;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TestimonialRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\TestimonialResource;
use App\Http\Requests\Api\UpdateTestimonialRequest;

class TestimonialController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = TestimonialResource::collection(Testimonial::all());

        return $this->success($testimonials, 'Testimonials fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Testimonials', 'public'); // Save in 'storage/app/public/Testimonials'
        }

        $testimonial = Testimonial::create($validated);

        return $this->success(TestimonialResource::make($testimonial), 'Testimonial created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return $this->success(TestimonialResource::make($testimonial), 'Testimonial fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Testimonials', 'public');
        }

        $testimonial->update($validated);

        return $this->success(TestimonialResource::make($testimonial->refresh()), 'Testimonial updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return $this->success(null, 'Testimonial deleted successfully', 200);
    }
}
