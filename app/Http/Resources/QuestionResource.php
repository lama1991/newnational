<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'uuid'=>$this->uuid,
             'content'=>$this->content,
             'reference'=>$this->reference,
             'college'=>new CollegeResource($this->college),
             'term'=>new TermResource($this->term),
             'specialization'=>new SpecializationResource($this->specialization),
             'answers'=>new AnswerResource($this->answers)
             ];
    }
}
