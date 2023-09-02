<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\Notification as NotificationModel;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        try{
           $notifications=NotificationModel::all();
            $data=array();
            $data['notifications']=NotificationResource::collection($notifications);
            return  $this-> apiResponse($data,true,'all notifications are here ',200);

        }
        catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }
    public function updateToken(Request $request)
    {
       
        try
        {
            auth('sanctum')->user()->update(['fcm-token'=>$request->fcmToken]);
            return  $this-> apiResponse([],true,'token updated',200);
        }
        catch(\Exception $ex)
        {
            report($ex);
       return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }
    
    
    public function add(Request $request)
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
            $data['uuid'] = Str::uuid()->toString();
            $notification=NotificationModel::create($data);
            $data2['Notification'] =new NotificationResource($notification) ;
                return $this->apiResponse($data2, true, 'notification added ', 201);
           
        } 

 catch (\Exception $ex)
 {
  return $this->apiResponse([], false,$ex->getMessage() ,500);
 }
    }

   public function send($uuid)
   {
    try {
       //find notification to be sent 
      $notification=NotificationModel::where('uuid',$uuid)->first();
      $fcmTokens = User::whereNotNull('fcm-token')->pluck('fcm-token')->toArray();
      Notification::send(null,new SendPushNotification($notification,$fcmTokens));
      return $this->apiResponse([], true, 'notification sended ', 200);  
     } 

    catch (\Exception $ex)
    {
    return $this->apiResponse([], false,$ex->getMessage() ,500);
    }
   }
}
