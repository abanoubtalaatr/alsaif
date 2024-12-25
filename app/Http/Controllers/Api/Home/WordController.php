<?php

namespace App\Http\Controllers\Api\Home;

use App\Models\Word;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\WordResource;
use App\Http\Requests\Api\Home\WordRequest;
use App\Http\Requests\Api\Home\UpdateWordRequest;

class WordController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Word = WordResource::make(Word::first());

        return $this->success($Word, 'Word fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WordRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('Word', 'public'); // Save in 'storage/app/public/Words'
        }

        $Word = Word::create($validated);

        return $this->success(WordResource::make($Word), 'Word created successfully', 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        return $this->success(WordResource::make($word), 'Word fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWordRequest $request)
    {
        $word = Word::first();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($word->image) {
                Storage::disk('public')->delete($word->image);
            }

            // Save the new image
            $validated['image'] = $request->file('image')->store('Word', 'public');
        }

        $word->update($validated);

        return $this->success(WordResource::make($word->refresh()), 'Word updated successfully', 200);
    }

}
