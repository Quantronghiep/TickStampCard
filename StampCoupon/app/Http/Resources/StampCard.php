<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StampCard extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        dd($request);
        // return [
        //     'app_name' => $this->app_name,
        //     'max_stamp' => $this->max_stamp,
        //     // 'status' => 'success'
        // ];
        return parent::toArray($request);
    }
}
