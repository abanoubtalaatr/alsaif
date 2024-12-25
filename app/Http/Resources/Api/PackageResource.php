<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'title'=> $this->title,
            'description' => $this->description,
            'features' => $this->features,
            'price' => $this->price,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
