<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'name' => $this->name,
            'country' => $this->country,
            'budget' => $this->budget,
            'total_value' => $this->total_value,

            'players' => [
                'starters' => PlayerResource::collection($this->whenLoaded('starters')),
                'bench'    => PlayerResource::collection($this->whenLoaded('bench')),
            ],
        ];
    }
}
