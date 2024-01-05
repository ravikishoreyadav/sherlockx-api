<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'group_id'      => $this->id,
            'name'          => $this->name,
            'is_active'     => $this->is_active,
            'group_type'    => $this->group_type
        ];
    }

}
