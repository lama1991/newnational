<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\UploadTrait;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use GeneralTrait,UploadTrait;
   
   public function index()
   {
      
        try{
           $users=User::all();
          
         // $data['profiles']=UserProfileResource::collection($users);
       
          return  $this-> apiResponse($users,true,'all profiles are here ',200);
        
        
          
           }
          catch (\Exception $ex){
              return  $this-> apiResponse([],false,$ex->getMessage(),500);
           }
   }

  

  
    public function store(Request $request)
    {
        //
    }

    // this find the profile depening on user's uuid
    public function show($user_uuid)
    {
        try{
        $user=User::where('uuid',$user_uuid)->first();
      
        $data['profile']=new UserProfileResource( $user);
        return  $this-> apiResponse($data,true,'user profile',200);
    }
    catch (\Exception $ex)
    {
        return $this->apiResponse([], false,$ex->getMessage() ,500);
    }
    }

 
  public function update(Request $request)
    {
       $validator=Validator::make($request->all(),[
            'name' => ['required'  ,'string'],
            'phone'=> ['required' ,'string'],
           ]
        );
      
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
        try{
        $data=$validator->validated();
        $user= auth('sanctum')->user();
       
         $user->update($data);
       $data=array();
        $data['profile']=new UserResource( $user);
         return  $this-> apiResponse($data,true,'user profile was updated succefully',200);
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }
 public function updatePhoto(Request $request)
 {
    $validator=Validator::make($request->all(),[
        'photo2'=>'required|image'
        ]
    );
    if($validator->fails()){
        return $this-> apiResponse([], false,$validator->errors(),422);
    }
    try
    {
    $user= auth('sanctum')->user();

    if($request->hasFile('photo2'))
    {
     $file=$request->file('photo2');
     $path=$this->uploadOne($file, 'profiles');
     $user->profile()->update(['photo'=>$path]);
     }
    
 
    $data=new ProfileResource($user->profile);
    return  $this-> apiResponse($data,true,'user profile was updated succefully',200);
    }
    catch (\Exception $ex)
    {
        return $this->apiResponse([], false,$ex->getMessage() ,500);
    }

 }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
    public function myProfile()
    {
       
        try{
            $user= auth('sanctum')->user();;
           
            $data['profile']=new UserProfileResource( $user);
          
            return  $this-> apiResponse($data,true,'user profile',200);
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }

    }
}
