<?php

namespace App\Http\Resources\Revenue;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'net_untuk_resto' => $this['net_untuk_resto'],
            'share_untuk_ojol'  => $this['share_untuk_ojol'],
        ];
    }
}
