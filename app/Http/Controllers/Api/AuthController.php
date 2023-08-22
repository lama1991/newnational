<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CollegeResource;
use App\Models\Code;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Models\College;
use Illuminate\Validation\Rule;

class AuthController
{
    use GeneralTrait;
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'name' => ['required' ,'string'],
            'phone'=> ['required' ,'string'],
            'college_id'=>['required' ,'numeric']
        ]);

        if($validator->fails()){
            return $this-> apiResponse([], false,$validator->errors(),422);
           
        }
        try {
            $user=User::where('name',$request['name'])
            ->where('phone',$request['phone'])
            ->first();
            if(!$user)
            {
                $data=[
                    'name'=>$request['name'],
                    'phone'=>$request['phone'],
                    'role' =>'student',
                    'uuid' => Str::uuid()->toString()
    
                   ];
                $user=User::create( $data);
                $user->profile()->create(['uuid'=> $uuid = Str::uuid()->toString(),'photo'=>'']);
            }
          
           
            $code=$user->codes()->where('college_id',$request['college_id'])->exists();
            // the user is trying to register a college he already has registered
             if($code)
             {
                return $this-> apiResponse([],false,'conflict!..you already registered in this college ' , 409);
             }
             else
             {
                //add the user_id and college_id to the codes table 
                //with code = null untill the user pays
                $user->codes()->create([
                    'uuid' => Str::uuid()->toString(),
                   'college_id'=>$request['college_id']
                ]);
             }
           
            return $this-> apiResponse([],true,'User is registered successfully.' , 200);
        
            
        }
        catch (\Exception $ex){
          return $this->apiResponse([], false,$ex->getMessage() ,500);
          
        }
    }
    //generate and store code
    public function giveCode(Request $request )
    {
       try
       {
        $name=$request['name'];
        $phone=$request['phone'];
        $college_id=$request['college_id'];
        $user=User::where('name',$name)
        ->where('phone',$phone)
        ->first();
       $code=$user->codes()->where('college_id',$college_id)->first();
       if($code && $user)
       
       {
        $random=Str::random(10);
         while(Code::where('code', $random)->exists())
            {
                $random=Str::random(10);
            }
            DB::beginTransaction();
            $user->update(['is_active'=>true]);
             $code->update([  'code'=>$random]);
              $data=array();
             $data['code']=$random;

            DB::commit();
            return $this-> apiResponse($data,true,'code is saved successfully.' , 200);
       }
       else
       {
        return $this-> apiResponse([],false,'try to register again.' , 404);
       }
    
       }
       catch (\Exception $ex){
        DB::rollback();
        return $this->apiResponse([], false,$ex->getMessage() ,500);}
        
   
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
     public function login(Request $request)
     {
         $validator =Validator::make($request->all(),[
             'name' => 'required|string',
             'code'=>'required|string'
         ]);
         if($validator->fails()){
            return $this-> apiResponse([], false,$validator->errors(),422);
         }

 try {
   
  
    $code=Code::where('code',$request['code'])->first();
    if($code)
    {
        $user=$code->user;
        if($user->name==$request['name'])
        {
            $college=$code->college;
            // create the token after the cradrntial is true
            // and save the college_id corresponding to the code he used to use in the middleware  
            $token = $user->createToken('MyApp',$college->id)->plainTextToken;
            
            $data = [
            'user' => new UserResource( $user),
             'token' => $token,
             'college'=>new CollegeResource($college)
              ];
              return $this-> apiResponse($data,true,'User has logged in successfully.',200);
        }
        else
        {
            return $this-> apiResponse([], false,'you dont have this code', 400);
        }
    }
    else
    {
        return $this-> apiResponse([], false,'incorrect code', 400);
    }

   
  

 }
         catch(\Exception $ex)
         {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
         }

     }

    public function logout(Request $request)
    {
        auth('sanctum')->user()->currentAccessToken()->delete();
        return $this->apiResponse([], true,'User has logged out successfully.' ,200);
    
    }
  


}
