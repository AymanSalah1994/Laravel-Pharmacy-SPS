<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'ordered_at' => $this->created_at,
            // 'assigned_pharmacy' 
            // TODO: 
            // Other Fields For this Later
        ];
    }
}
