<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'severity' => $this->severity,
            'issued_at' => $this->issued_at,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'address' => $this->address ? [
                'id' => $this->address->id,
                'formatted_address' => $this->address->formatted_address,
                'latitude' => $this->address->latitude,
                'longitude' => $this->address->longitude,
            ] : null,
        ];
    }
}
