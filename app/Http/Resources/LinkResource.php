<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id_link,
            'link'       => $this->original_url,
            'short'      => $this->short_url,
            'expires_at' => $this->expires_at,
            'clicks'     => $this->clicks_count,
            'user_id'    => $this->code_user
        ];
    }
}
