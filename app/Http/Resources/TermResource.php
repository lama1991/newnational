<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SpecializationResource;
class TermResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
    public function toArray($request)
    {
      
        
        return [
            
            'id'=>$this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
           'specialization'=>new SpecializationResource($this->specialization),

        ];
       
    }
}
