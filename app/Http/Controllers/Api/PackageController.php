<?php

namespace App\Http\Controllers\Api;

use App\Models\Package;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PackageRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\PackageResource;
use App\Http\Requests\Api\UpdatePackageRequest;

class PackageController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Packages = PackageResource::collection(Package::all());

        return $this->success($Packages, 'Packages fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Packages', 'public'); // Save in 'storage/app/public/Packages'
        }

        $Package = Package::create($validated);

        return $this->success(PackageResource::make($Package), 'Package created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return $this->success(PackageResource::make($package), 'Package fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Packages', 'public');
        }

        $package->update($validated);

        return $this->success(PackageResource::make($package->refresh()), 'Package updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return $this->success(null, 'Package deleted successfully', 200);
    }
}
