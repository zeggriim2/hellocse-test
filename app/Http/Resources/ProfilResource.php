<?php

namespace App\Http\Resources;

use App\Models\Profil;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Profil $resource
 */
class ProfilResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->resource->id,
            'nom'       => $this->nom,
            'prenom'    => $this->prenom,
            'image'     => $this->image,
            'status'    => $this->resource->status
        ];
    }
}
