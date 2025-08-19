<?php

namespace App\Http\Resources\Api\Pajak;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PajakResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'net_sales' => $this->net_sales,
            'pajak_rp'  => $this->pajak_rp,
        ];
    }
}