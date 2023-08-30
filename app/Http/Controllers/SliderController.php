<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\UploadTrait;
class SliderController extends Controller
{
    use GeneralTrait,UploadTrait;
    public function index()
    {
        try{
             $sliders=Slider::all();
             $data=array();
           $data['sliders']=SliderResource::collection( $sliders);
           return  $this-> apiResponse($data,true,'all sliders are here ',200);

           }
          catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
           }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'image'=>'required|image|mimes:jpeg,png,jpg,svg',
             'link'=>  'string',

            ]
        );
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
      try {
          $msg='slider is created successfully';
         $data= $validator->validated();
          if($request->hasFile('image'))
          {
            $file=$request->file('image');
            $data['image_url']=$this->uploadPublic($file,'images/slider');

          }
          $slider=Slider::create($data);
      $data2=array();
      $data2['slider']=new SliderResource($slider);
         return  $this-> apiResponse( $data2 ,true, $msg,201);

        }
        catch (\Exception $ex)
        {
            return $this->apiResponse((object)[], false,$ex->getMessage() ,500);
        }
    }

    public function show($uuid)
    {
        try {
            $slider=Slider::where('uuid',$uuid)->first();
            if(!$slider)
            {
                return  $this-> apiResponse([],false,'no slider with such uuid',404);
            }
            $msg='slider is here';
            $data['slider']=new SliderResource($slider);
           return  $this-> apiResponse($data,true, $msg,200);
          }
          catch (\Exception $ex)
          {
              return $this->apiResponse([], false,$ex->getMessage() ,500);
          }
    }
}
