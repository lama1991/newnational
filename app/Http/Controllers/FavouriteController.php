<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavouriteResource;
use App\Http\Resources\ProfileResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FavouriteController extends Controller
{
    use  GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    {   $user=Auth::user();
        $validator=Validator::make($request->all(),[
                'question_id'=>'required|numeric']
        );
        if($validator->fails()){
            return $this-> apiResponse([], false,$validator->errors(),422);
        }
        try {
            if (auth('sanctum')->check()) {
                $user = auth('sanctum')->user();
                $data = $validator->validated();
                $data['user_id'] = $user->id;
                $data['uuid'] = Str::uuid()->toString();
                $favourite = Favourite::create($data);
                $msg = 'Answer is created successfully';
                $data2 = array();
                $data2['favourite'] = new FavouriteResource($favourite);
                return $this->apiResponse($data2, true, $msg, 201);
            } else {
                return $this->apiResponse([], false, 'User not authenticated', 401);
            }
    }
     catch (\Exception $ex)
     {
      return $this->apiResponse([], false,$ex->getMessage() ,500);
     }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myFavourite()
    {
        try {
            if (auth('sanctum')->check()) {
                $user = auth('sanctum')->user();
                $favorites = Favourite::where('user_id', $user->id)->get();
                $data = array();
                $data['favorites'] = FavouriteResource::collection($favorites);
                return $this->apiResponse($data, true, 'Favorites retrieved successfully', 200);
            } else {
                return $this->apiResponse((object) [], false, 'User not authenticated', 401);
            }
        } catch (\Exception $ex) {
            return $this->apiResponse((object) [], false, $ex->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
