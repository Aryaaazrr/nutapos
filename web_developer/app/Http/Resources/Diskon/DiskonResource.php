<?php

namespace App\Http\Resources\Diskon;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiskonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_diskon' => $this['total_diskon'],
            'total_harga_setelah_diskon'  => $this['total_harga_setelah_diskon'],
        ];
    }
}
