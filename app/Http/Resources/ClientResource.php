<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'company' => $this->company ? [
                'id' => $this->company->id,
                'name' => $this->company->name,
            ] : null,
            'person' => $this->person ? [
                'id' => $this->person->id,
                'name' => $this->person->getFullName(),
            ] : null,
        ];
    }
}
