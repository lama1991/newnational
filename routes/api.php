<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SliderController;
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
Route::get('/specializations-of-college/{id}',[CollegeController::class,'specializationsof'])->middleware(['college','auth:sanctum']);

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

Route::get('question/all',[QuestionController::class,'index']);
Route::post('question/create',[QuestionController::class,'store']);
Route::get('question/{uuid}',[QuestionController::class,'show']);

Route::get('answer/all',[AnswerController::class,'index']);
Route::get('answer/{uuid}',[AnswerController::class,'show']);

Route::get('/setnullable', function () {
    shell_exec('(cd '.base_path().' && composer require doctrine/dbal)');
 
});
Route::get('/setnullable2', function () {
   
  Artisan::call('migrate --path=database/migrations/2023_08_21_213509_changetonullable.php');
});

Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::post('/logout',[AuthController::class,'logout']);
});
