<?php

namespace App\Http\Resources\Administrator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdministratorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // $this->collection->load('representing');
        // return [
        //     'data' => $this->collection,
        // ];

        $administrators = $this->collection->map(function ($administrator) {
            $administrator->load('representing');

            return $administrator;
        });

        return [
            'success' => true,
            'message' => 'Recuperation des administrateurs avec succès',
            'data' => AdministratorResource::collection($administrators),
        ];
    }
}
