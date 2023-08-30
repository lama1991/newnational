<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollegeResource;
use App\Http\Resources\SpecializationResource;
use App\Models\College;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\UploadTrait;
use Illuminate\Support\Facades\Config;
class CollegeController extends Controller
{
    use GeneralTrait,UploadTrait;

    public function index()
    {
        try{
         $colleges=College::all();
         $data=array();
         $data['colleges']=CollegeResource::collection( $colleges);
        return  $this-> apiResponse($data,true,'all colleges are here ',200);

        }
       catch (\Exception $ex){
        return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }


    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
             'category_id'=>  'required|numeric',
             'logo2'=>'required|image|mimes:jpeg,png,jpg,svg'
            ]
        );
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
      try {

          $uuid = Str::uuid()->toString();
           $data= $validator->validated();
          $data['uuid']=$uuid;
          // Check if college already exists in the database
          $collegeExists = College::where('name', $data['name'])->exists();
          if ($collegeExists) {
              return $this->apiResponse([], false, 'College already exists', 422);
          }

          if($request->hasFile('logo2'))
          {
            $file=$request->file('logo2');
          


            $data['logo']=$data['logo']=$this->uploadPublic($file,'images/college');

          }
          $college=College::create($data);
          $msg='college is created successfully';
          $data2=array();
          $data2['college']=new CollegeResource($college);
         return  $this-> apiResponse($data2,true, $msg,201);

        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }


    public function show($id)
    {
        try {
            $college=College::find($id);
            if(!$college)
            {
                return  $this-> apiResponse([],false,'no college with such id',404);
            }
            $msg='college is here';
            $data=array();
            $data['college']=new CollegeResource($college);
           return  $this-> apiResponse($data,true, $msg,200);
          }
          catch (\Exception $ex)
          {
              return $this->apiResponse([], false,$ex->getMessage() ,500);
          }
    }

    public function specializationsof($id)
    {
        try
        {
         $college=College::find($id);
        if(!$college)
        {
             return  $this-> apiResponse([],false,'no college with such id',404);
        }
       $specializations=$college->specializations;
       $data=array();
        $data['specializations']=SpecializationResource::collection( $specializations);
        return  $this-> apiResponse($data,true,'all specializations of college are here ',200);
        }
        catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function edit(College $college)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, College $college)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy(College $college)
    {
        //
    }
    public function masterSpec($id)
    {
        try{
            $college=College::find($id);
            if(!$college)
            {
                return  $this-> apiResponse([],false,'no college with such id',404);
            }
            
            $specializations= $college->specializations()->where('is_master',1)->get();
           $data['specializations']=SpecializationResource::collection($specializations);
            return $this->apiResponse(  $data,true,'master specializations',200);
        }
        catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }
    // public function degree($id)
    // {
    //     try{
    //         $college=College::find($id);
    //         if(!$college)
    //         {
    //             return  $this-> apiResponse([],false,'no college with such id',404);
    //         }
    //         $master= $college->specializations()->where('is_master',1)->exists();
    //         if($master)
    //         {   
    //             $data['master']=1;
    //             return $this->apiResponse( $data,true,'this college has master',200);
    //         }
    //         else
    //         {
    //             $data['master']=0;
    //             return $this->apiResponse( $data,true,'this college not have master',200);
    //         }
         
    //     }
    //     catch (\Exception $ex){
    //         return $this->apiResponse([], false,$ex->getMessage() ,500);
    //     }
    // }
}
