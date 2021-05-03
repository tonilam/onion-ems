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
        $linked_name = null;
        if ($this->person) {
            $linked_name = $this->person->getFullName();
        }
        if ($this->company) {
            $linked_name = $this->company->name;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'linked_name' => $linked_name,
            'company_id' => $this->company_id,
            'person_id' => $this->person_id,
        ];
    }
}
