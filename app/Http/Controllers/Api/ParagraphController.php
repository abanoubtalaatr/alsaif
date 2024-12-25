<?php

namespace App\Http\Controllers\Api;

use App\Models\Paragraph;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ParagraphRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\ParagraphResource;
use App\Http\Requests\Api\UpdateParagraphRequest;

class ParagraphController extends Controller
{
    use ApiResponse;
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(ParagraphRequest $request)
    {
        $validated = $request->validated();

        $Paragraph = Paragraph::create($validated);

        return $this->success(ParagraphResource::make($Paragraph), 'Paragraph created successfully', 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParagraphRequest $request, Paragraph $paragraph)
    {
        $validated = $request->validated();

        $paragraph->update($validated);

        return $this->success(ParagraphResource::make($paragraph->refresh()), 'Paragraph updated successfully', 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paragraph $paragraph)
    {
        $paragraph->delete();

        return $this->success(null, 'Paragraph deleted successfully', 200);
    }
}
