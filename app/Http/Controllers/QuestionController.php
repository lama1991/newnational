<?php

namespace App\Http\Controllers;


use App\Http\Traits\GeneralTrait;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Term;

use Doctrine\DBAL\Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\QuestionResource;
use App\Models\Specialization;

use function PHPUnit\Framework\isTrue;

class QuestionController extends Controller
{
    use GeneralTrait;
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $questions=Question::all();
            $data=array();
            $data['questions']=QuestionResource::collection($questions);
           return  $this-> apiResponse($data,true,'all questions are here ',200);

           }
          catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
           }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'content'=>'required|string',
            'reference'=>'required|string',
             'term_id'=>  'numeric',
             'specialization_id'=>  'numeric',
             'college_id'=>'required|numeric',

               ]
        );
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
      try {


           $data= $validator->validated();
          $data['uuid']=Str::uuid()->toString();
        $question=Question::create($data);

          $msg='question is created successfully';
          $data2=array();
          $data2['question']=new QuestionResource($question);
        
         return  $this-> apiResponse($data2,true, $msg,201);

        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try{

            $question=Question::where('uuid',$uuid)->first();
            if (!$question) {
                return $this->apiResponse([], false,'Question not found',404);
         
            }
           $data['question']=new QuestionResource($question);
            return  $this-> apiResponse($data,true,'question is here',200);
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }

    public function getQuestionsByTerm($uuid)
    {

        try
        {
            $term = Term::where('uuid',$uuid)->first();

            if (!$term) {
                return $this-> apiResponse([],false,'no term with such uuid', 404);
            }

            $questions = $term->questions;
            $data=array();
            $data['questions']=QuestionResource::collection( $questions);

            return  $this-> apiResponse($data,true,'all questions of term are here ',200);

        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }
    public function getQuestionsBySpecialization($uuid)
    {

        try
        {
            $specialization = Specialization::where('uuid',$uuid)->first();

            if (!$specialization) {
                return $this-> apiResponse([],false,'no Specialization with such uuid', 404);
            }

            $questions = $specialization->questions;
            $data=array();
            $data['questions']=QuestionResource::collection( $questions);

            return  $this-> apiResponse($data,true,'all questions of specialization are here ',200);

        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }
    }

    public function calculateMark(Request $request)
    {
    try
    {
        //المصفوفة المرسلة من قبل الفرونت
    $answers = $request->input('answers');
    $totalMarks = 0;
        $trueCount = 0;
        $falseCount = 0;


        //عم نمشي على المصفوقة
    foreach ($answers as $answer) {

        $question_uuid = $answer['question_uuid'];
        $answer_uuid = $answer['answer_uuid'];
        //جبنا السؤال على حسب uuid

        $question = Question::where('uuid',$question_uuid)->first();
        $questionByUuid=new QuestionResource($question);
        $answer_selected= $answer['answer_uuid'];
        $questionsWithAnswers[]= [
            'question' => $questionByUuid,
            'answer_selected' => $answer_selected
        ];

        $answers = $question->answers;

        foreach ($answers as $answer) {
            if ($answer->is_true==true && $answer->uuid == $answer_uuid) {
                $totalMarks+=2;
                $trueCount++;
                break;
            } else if ($answer->is_true == false && $answer->uuid == $answer_uuid) {
                $falseCount++;
                break;
            }
        }
        $data=['marks' => $totalMarks,
            'true_count'=>$trueCount,
            'false_count'=>$falseCount,
          'questions' => $questionsWithAnswers
        ];
    }

    return  $this-> apiResponse($data,true,'this is your mark ',200);
   }
   catch (\Exception $ex){
    return $this->errorResponse($ex->getMessage(),500);
   }
    }



}
