<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;



class CategoryController extends ApiController
{
    
    public function index()
    {
        $category=Category::All();
        return $this->showAll($category);
    }

    public function store(Request $request)
    {
         $rules = [
            
            'name' => 'required|unique:categories',
            'description' => 'required',
           
        ];
        $this->validate($request,$rules);
        $category=Category::create($request->all());
        return $this->showOne($category);
    }

    
    public function show(Category $category)
    {
       return $this->showOne($category);
    }

    
    public function edit(Category $category)
    {
        //
    }

    
    public function update(Request $request, Category $category)
    {
        // $rules = [
            
        //     'name' => 'unique:categories',
            
           
        // ];
        // $this->validate($request,$rules);

        $category->fill($request->only([
            'name',
            'description'
        ]));
        if($category->isClean()){
            return $this->errResponse('You need to specify any different value to update',422);

        }
        $category->save();
        return $this->showOne($category);
    }

    
    public function destroy(Category $category)
    {
      $category=$category->delete();
      return response()->json("SuccessFully Removed",402);
    }
}
