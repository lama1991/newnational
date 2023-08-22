<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        try{
           
            $answers=Answer::all();
            $data=array();
            $data['answers']=AnswerResource::collection($answers);
           return  $this-> apiResponse($data,true,'all answers are here ',200);
          
           }
          catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
           }
    }
    public function show($uuid)
    {
        try{
          
           $answer=Answer::where('uuid',$uuid)->first();
           $data['answer']=new AnswerResource($answer);
            return  $this-> apiResponse($data,true,'answer is here',200);
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }
}
