<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferListingResource extends JsonResource
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
            'price' => $this->price / 100,
            'is_active' => (bool) $this->is_active,

            'player' => new PlayerResource(
                $this->whenLoaded('player')
            ),

            'seller_team' => [
                'id' => $this->sellerTeam?->id,
                'name' => $this->sellerTeam?->name,
            ],

            'created_at' => $this->created_at,
        ];
    }
}
