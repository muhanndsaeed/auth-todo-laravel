<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
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
            'user_id'=> $this->user_id,
            'name'=> $this->name,
            'details'=> $this->details,
            'created_at'=> $this->created_at->format('Y/m/d'),
            'updated_at'=> $this->updated_at->format('Y/m/d'),
        ];
        // return parent::toArray($request);
    }
}
