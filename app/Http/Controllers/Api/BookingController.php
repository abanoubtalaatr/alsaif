<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BookingRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\BookingResource;
use App\Http\Requests\Api\UpdateBookingRequest;

class BookingController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Bookings = BookingResource::collection(Booking::all());

        return $this->success($Bookings, 'Bookings fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Bookings', 'public'); // Save in 'storage/app/public/Bookings'
        }

        $booking = Booking::create($validated);

        return $this->success(BookingResource::make($booking), 'Booking created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return $this->success(BookingResource::make($booking), 'Booking fetched successfully', 200);
    }

    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return $this->success(null, 'Booking deleted successfully', 200);
    }
}
