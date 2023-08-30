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
      $data = parent::toArray($request);

      foreach ($data as $key => $value) {
          if ($value === null) {
              $data[$key] = (object) [];
          }
      }
      
        return[
       
           'uuid'=>$this->uuid,
             'content'=>$this->content,
             'reference'=>$this->reference,
             'college'=>new CollegeResource($this->college),

         
         'term'=> $this->term?new TermResource($this->term) :(object)[],
         'specialization'=>$this->specialization  ?new SpecializationResource($this->specialization) :(object)[],
        

            'answers'=>AnswerResource::collection($this->answers)

             ];
    }
}
