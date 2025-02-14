<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $recipient
 * @property mixed $street1
 * @property null|mixed $street2
 * @property mixed $city
 * @property mixed $state
 * @property mixed $zip
 * @property mixed $message
 * @property mixed $image
 */
class CardResource extends JsonResource
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
            'recipient' => $this->recipient,
            'street1' => $this->street1,
            'street2' => $this->street2,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'message' => $this->message,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
        ];
    }
}
