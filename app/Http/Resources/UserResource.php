<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'attributes' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'contact_no' => $this->contact_no,
                'company' => $this->company,
                'username' => $this->username,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'actions' => [
                'edit' => true,
                'delete' => true
            ]
        ];

        return $data;
    }
}
