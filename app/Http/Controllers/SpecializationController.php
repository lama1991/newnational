<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTrait;
use App\Http\Resources\SpecializationResource;
class SpecializationController extends Controller
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
            $specialization=Specialization::all();
            $data=array();
            $data['specialization']=SpecializationResource::collection($specialization);
            return  $this-> apiResponse($data,true,'all specializations are here ',200);

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
                'college_id'=>'required|numeric',
            ]
        );
        if($validator->fails()){
            return $this-> apiResponse([], false,$validator->errors(),422);
        }
        try {
            $msg='Specialization is created successfully';
            $uuid = Str::uuid()->toString();
            $data= $validator->validated();
            $data['uuid']=$uuid;

            $specialization=new SpecializationResource(Specialization::create($data));
            $data2=array();
            $data2['specialization']= $specialization;

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
     * @param  \App\Models\Specialization  $specialization
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $specialization=Specialization::find($id);
            if(!$specialization)
            {
                return  $this-> apiResponse([],false,'no spezalization with such id',404);
            }
            $msg='Specialization is here';
            $data=array();
            $data['Specialization']=new SpecializationResource($specialization);
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
     * @param  \App\Models\Specialization  $specialization
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialization $specialization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialization  $specialization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialization $specialization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialization  $specialization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialization $specialization)
    {
        //
    }
}
