<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CollegeResource;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\UploadTrait;
use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    use GeneralTrait,UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $categories=Category::all();
            $data=array();
           $data['categories']=CategoryResource::collection( $categories);
           return  $this-> apiResponse($data,true,'all categories are here ',200);
          
           }
          catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
           }
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
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'logo2'=>'required|image'
            ]
        );
                if($validator->fails()){
                    return $this-> apiResponse([], false,$validator->errors(),422);
        }
      try {
          $msg='category is created successfully';
          $uuid = Str::uuid()->toString();
          $data= $validator->validated();
         $data['uuid']=$uuid;
         if($request->hasFile('logo2'))
         {
          $file=$request->file('logo2');
          $path=$this->uploadOne($file, 'categories');
       
          $data['logo']=$path;

         }
         $category=new CategoryResource(Category::create($data));
         $data2=array();
         $data2['category']= $category;
     
         return  $this-> apiResponse($data2,true, $msg,201);
       
        }
        catch (\Exception $ex)
        {
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $category=Category::find($id);
            if(! $category)
            {
                return  $this-> apiResponse([],false,'no category with such id',404);
            }
            $msg='category is here';
            $data=array();
           $data['category']=new CategoryResource($category);
           return  $this-> apiResponse($data,true, $msg,200);
          }
          catch (\Exception $ex)
          {
              return $this->apiResponse([], false,$ex->getMessage() ,500);
          }
    }
    public function colleges($id)
    {
        try
        {
        $category=Category::find($id);
         if(! $category)
            {
                return  $this-> apiResponse([],false,'no category with such id',404);
            }
        $colleges=$category->colleges;
        $data=array();
        $data['colleges']=CollegeResource::collection( $colleges);
        return  $this-> apiResponse($data,true,'all colleges of category are here ',200);
        }
        catch (\Exception $ex){
            return $this->apiResponse([], false,$ex->getMessage() ,500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
