<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollegeResource extends JsonResource
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
        'logo'=>url($this->logo),    
         'is_master'=> $this->specializations()->where('is_master',1)->exists(),
           'category'=>new CategoryResource($this->category),
      

       ];
    }
}
