<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CollegeResource;
class SpecializationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return[
           'id'=>$this->id,
       'uuid'=>$this->uuid,
        'name'=>$this->name,
           'college'=>new CollegeResource($this->college),
           'is_master'=>$this->is_master,

       ];
    }
}
