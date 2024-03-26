<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' =>  DateTime::createFromFormat('Y-m-d', $this->exchange_date)->format('M Y'),
            'exchange_date' => $this->exchange_date,
            'value' => $this->value,
        ];
    }
}
