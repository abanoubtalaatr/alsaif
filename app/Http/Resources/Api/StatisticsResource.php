<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'description' => $this->description,
            'created_at'=> Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
