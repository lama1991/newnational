<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\TermController;

/*-------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/give-code',[AuthController::class,'giveCode'])->name('give.code');
Route::get('/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);


Route::get('/college/all',[CollegeController::class,'index']);
Route::post('/college/create',[CollegeController::class,'store']);
Route::get('/college/{id}',[CollegeController::class,'show']);
Route::get('/specializations-of-college/{id}',[CollegeController::class,'specializationsof'])->middleware(['auth:sanctum']);

Route::get('/category/all',[CategoryController::class,'index']);
Route::post('/category/create',[CategoryController::class,'store']);
Route::get('/category/{id}',[CategoryController::class,'show']);
Route::get('/colleges-of-category/{id}',[CategoryController::class,'colleges']);

Route::post('/profile/update',[ProfileController::class,'update'])->middleware(['auth:sanctum']);
Route::get('/profile/{user_uuid}',[ProfileController::class,'show']);
Route::get('/my-profile',[ProfileController::class,'myProfile'])->middleware(['auth:sanctum']);;
Route::get('/profile/all',[ProfileController::class,'index']);
Route::post('/profile/update-photo',[ProfileController::class,'updatePhoto'])->middleware(['auth:sanctum']);;


Route::get('/slider/all',[SliderController::class,'index']);
Route::get('/slider/{id}',[SliderController::class,'show']);
Route::post('/slider/create',[SliderController::class,'store']);

Route::get('/specialization/all',[SpecializationController::class,'index']);
Route::post('/specialization/create',[SpecializationController::class,'store']);
Route::get('/specialization/{id}',[SpecializationController::class,'show']);
Route::get('/specialization/{college_id}/{specialization_id}',[SpecializationController::class,'destroy']);
Route::get('/terms-of-specializations/{id}',[SpecializationController::class,'termsOf']);


Route::get('/term/all',[TermController::class,'index']);
Route::post('/term/create',[TermController::class,'store']);
Route::get('/term/{id}',[TermController::class,'show']);
Route::get('/getTermsBySpecialization/{id}',[TermController::class,'getTermsBySpecialization']);
Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::post('/logout',[AuthController::class,'logout']);
});
