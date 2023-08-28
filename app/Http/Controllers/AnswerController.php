<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnswerController extends Controller
{
    use GeneralTrait;
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'content'=>'required|string',
            'is_true'=>'required',
            'question_id'=>'required|numeric',
               ]
        );
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
      try {


           $data= $validator->validated();
          $data['uuid']=Str::uuid()->toString();
         $answer=Answer::create($data);
          $msg='answer is created successfully';
          $data2=array();
          $data2['answer']=new AnswerResource( $answer);
         return  $this-> apiResponse($data2,true, $msg,201);

        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }
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
    public function getAnswersByQuestion($uuid)
    {
        try
        {
            $question = Question::where('uuid',$uuid)->first();
              if (!$question) {
                return $this-> apiResponse([],false,'no question with such id', 404);
            }
            $answers = $question->answers;
            $data=array();
            $data['answers']=AnswerResource::collection( $answers);

            return  $this-> apiResponse($data,true,'all answers of question are here ',200);

        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }
}
