<?php

namespace App\Http\Controllers;

use App\Http\Resources\TermResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Specialization;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TermController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $term=Term::all();
            $data=array();
            $data['term']=TermResource::collection($term);
            return  $this-> apiResponse($data,true,'all terms are here ',200);

        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
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
                'name'=>'required|string',
                'specialization_id'=>'required|numeric',
            ]
        );
        if($validator->fails()){
            return $this-> apiResponse([], false,$validator->errors(),422);
        }
        try {
            $msg='Term is created successfully';
            $uuid = Str::uuid()->toString();
            $data= $validator->validated();
            $data['uuid']=$uuid;

            $term=new TermResource(Term::create($data));
            $data2=array();
            $data2['term']= $term;

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
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            $term=Term::where('uuid',$uuid)->first();
            if(!$term)
            {
                return  $this-> apiResponse([],false,'no term with such id',404);
            }
            $msg='Term is here';
            $data=array();
            $data['Term']=new TermResource($term);
            return  $this-> apiResponse($data,true, $msg,200);
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $term)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        //
    }
    public function getTermsBySpecialization($specializationId)
    {

        try
        {
            $specialization = Specialization::find($specializationId);

            if (!$specialization) {
                return $this-> apiResponse([],false,'no specialization with such id', 404);
            }

            $terms = $specialization->terms;
            $data=array();
            $data['terms']=TermResource::collection( $terms);

            return  $this-> apiResponse($data,true,'all terms of specialization are here ',200);

        }
        catch (\Exception $ex){
            return $this->errorResponse($ex->getMessage(),500);
        }

    }

}
