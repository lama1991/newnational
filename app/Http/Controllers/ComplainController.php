<?php

namespace App\Http\Controllers;

use App\Http\Resources\ComplainResource;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\Complain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ComplainController extends Controller
{
    use GeneralTrait;
    public function index()
    {
       
        try{

           
            $complains=Complain::all();
            
           $data['complains']=ComplainResource::collection($complains);
           return  $this-> apiResponse($data,true,'all complains are here ',200);

           }
          catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
           }
    }

    
    public function store(Request $request)
    {   
        $validator=Validator::make($request->all(),[
                'content'=>'required|string'
               ]
        );
        if($validator->fails()){
            return $this-> apiResponse([], false,$validator->errors(),422);
        }
        try {
            
               $data = $validator->validated();
                $data['user_id'] =Auth::id();
                $data['uuid'] = Str::uuid()->toString();
                $complain = Complain::create($data);
               
                $data2 = array();
                $data2['complain'] = new ComplainResource($complain);
                return $this->apiResponse($data2, true, 'you have complained succefully', 201);
            } 
    
     catch (\Exception $ex)
     {
      return $this->apiResponse([], false,$ex->getMessage() ,500);
     }
    }

    public function myComplains()
    {
        try {
           
                $user = Auth::user();
                $complains=$user->complains;
                $data['complains'] = ComplainResource::collection($complains);
                return $this->apiResponse($data, true, 'all of your complains', 200);
            
        } catch (\Exception $ex) {
            return $this->apiResponse((object) [], false, $ex->getMessage(), 500);
        }
    }

}
