<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\BookingRequest;
use App\Http\Resources\Api\BookingResource;
use App\Http\Requests\Api\UpdateBookingRequest;
use App\Mail\BookingConfirmation;


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
            $validated['image'] = $request->file('image')->store('Bookings', 'public');
        }

        $lastBooking = Booking::orderBy('id', 'desc')->first();
        $numberOfBookings = 3001;

        if (!is_null($lastBooking)) {
            $numberOfBookings = $lastBooking->number_of_bookings + 1;
        }
        $data = $validated;

        $data['number_of_bookings'] = $numberOfBookings;

            $booking = Booking::create($data);

            Mail::to($booking->email)->send(new BookingConfirmation($booking));

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

    public function getBookedTimes(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'], // Ensure the date is valid
        ]);

        $date = $request->input('date');

        // Fetch bookings for the given date
        $bookedTimes = Booking::whereDate('date', $date)->pluck('time');

        return $this->success($bookedTimes, 'Bookings fetched successfully', 200);
    }
}
