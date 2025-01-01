<?php

namespace App\Http\Controllers\Api;

use App\Models\Advantage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AdvantageRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\AdvantageResource;
use App\Http\Requests\Api\UpdateAdvantageRequest;

class AdvantageController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advantages = AdvantageResource::collection(Advantage::all());

        return $this->success($advantages, 'Advantages fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdvantageRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Advantages', 'public'); // Save in 'storage/app/public/Advantages'
        }

        $advantage = Advantage::create($validated);

        return $this->success(AdvantageResource::make($advantage), 'Advantage created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Advantage $advantage)
    {
        return $this->success(AdvantageResource::make($advantage), 'Advantage fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvantageRequest $request, Advantage $advantage)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')  && !is_null($request->image) &&  $request->image != 'null') {
            // Delete the old image if it exists
            if ($advantage->image) {
                Storage::disk('public')->delete($advantage->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Advantages', 'public');
        }

        $advantage->update($validated);

        return $this->success(AdvantageResource::make($advantage->refresh()), 'Advantage updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advantage $advantage)
    {
        $advantage->delete();

        return $this->success(null, 'Advantage deleted successfully', 200);
    }
}
