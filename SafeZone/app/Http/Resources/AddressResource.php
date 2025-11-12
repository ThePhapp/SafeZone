<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address_line' => $this->address_line,
            'district' => $this->district,
            'city' => $this->city,
            'province' => $this->province,
            'country' => $this->country,
            'postal_code'  => $this->postal_code,
            'google_place_id' => $this->google_place_id,
            'formatted_address' => $this->formatted_address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
