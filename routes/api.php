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
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\FavouriteController;
use Illuminate\Support\Facades\Artisan;
/*-------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/fresh', function () {
   
    Artisan::call('migrate:fresh');
  });
  Route::get('/seed', function () {
     
    Artisan::call('db:seed');
  });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/give-code',[AuthController::class,'giveCode'])->name('give.code');



Route::get('/college/all',[CollegeController::class,'index']);
Route::post('/college/create',[CollegeController::class,'store']);
Route::get('/college/{uuid}',[CollegeController::class,'show']);
Route::get('/specializations-of-college/{uuid}',[CollegeController::class,'specializationsof'])->middleware(['auth:sanctum']);
Route::get('/master-spec/{uuid}',[CollegeController::class,'masterSpec']);
//Route::get('/degrees/{id}',[CollegeController::class,'degree']);

Route::get('/category/all',[CategoryController::class,'index']);
Route::post('/category/create',[CategoryController::class,'store']);
Route::get('/category/{uuid}',[CategoryController::class,'show']);
Route::get('/colleges-of-category/{uuid}',[CategoryController::class,'colleges']);

Route::post('/profile/update',[ProfileController::class,'update'])->middleware(['auth:sanctum']);
Route::get('/profile/{user_uuid}',[ProfileController::class,'show']);
Route::get('/my-profile',[ProfileController::class,'myProfile'])->middleware(['auth:sanctum']);;
Route::get('/profile/get/all',[ProfileController::class,'index']);
Route::post('/profile/update-photo',[ProfileController::class,'updatePhoto'])->middleware(['auth:sanctum']);;


Route::get('/slider/all',[SliderController::class,'index']);
Route::get('/slider/{uuid}',[SliderController::class,'show']);
Route::post('/slider/create',[SliderController::class,'store']);

Route::get('/specialization/all',[SpecializationController::class,'index']);
Route::post('/specialization/create',[SpecializationController::class,'store']);
Route::get('/specialization/{uuid}',[SpecializationController::class,'show']);
Route::get('/bookQues/{uuid}',[SpecializationController::class,'bookQuest']);
Route::post('/specialization/{college_id}/{specialization_id}',[SpecializationController::class,'destroy']);


Route::get('question/all',[QuestionController::class,'index']);
Route::post('question/create',[QuestionController::class,'store']);
Route::get('question/{uuid}',[QuestionController::class,'show']);
Route::get('/questions-of-term/{uuid}',[QuestionController::class,'getQuestionsByTerm']);
Route::get('/questions-of-specialization/{uuid}',[QuestionController::class,'getQuestionsBySpecialization']);
Route::post('/calculate_mark',[QuestionController::class,'calculateMark']);


Route::get('answer/all',[AnswerController::class,'index']);
Route::post('answer/create',[AnswerController::class,'store']);
Route::get('answer/{uuid}',[AnswerController::class,'show']);
Route::get('/answers-of-question/{uuid}',[AnswerController::class,'getAnswersByQuestion']);






Route::get('/term/all',[TermController::class,'index']);
Route::post('/term/create',[TermController::class,'store']);
Route::get('/term/{uuid}',[TermController::class,'show']);
Route::get('/terms-of-specializations/{uuid}',[TermController::class,'getTermsBySpecialization']);

Route::post('favourite/create',[FavouriteController::class,'store'])->middleware(['auth:sanctum']);
Route::get('my_favourite',[FavouriteController::class,'myFavourite'])->middleware(['auth:sanctum']);

Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::get('/logout',[AuthController::class,'logout']);


});
