<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;
use App\Product;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    public function store(Request $request,User $seller)
    {
        $rules = [
            
            'name' => 'required|unique:categories',
            'description' => 'required',
            'quantity' =>'required|integer|min:1',
            'image' => 'image'
           
        ];
        $this->validate($request,$rules);
        $data=$request->all();

        $data['status'] =Product::UNAVAIABLE_PRODUCT;
        $data['image'] =$request->image->store('');
        $data['seller_id'] =$seller->id;

        $product=Product::create($data);

        return $this->showOne($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller,Product $product)
    {
        $rules = [
            
            'name' => 'unique:categories',
            'status' => 'in:' . Product::AVAIABLE_PRODUCT .','.Product::UNAVAIABLE_PRODUCT,
            'quantity' =>'integer|min:1',
            
           
        ];
        $this->validate($request,$rules);
        $this->checkSeller($seller ,$product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity',
            
        ]));
        if($request->has('status')){
            $product->status = $request->status;

            if($product->isAvaiable() && $product->categories()->count() ==0){
                return $this->errResponse('You need to specify a different value to update',422);
            }
       
        }
        // dd($request->image);
        
        if($request->image){
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }
        if(!$product->isDirty()){
            return $this->errResponse('An active product must have adifferent value to update',422);
        }
        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,Product $product)
    {
        $this->checkSeller($seller ,$product);
        Storage::delete($product->image);
        $product->delete();
        return response()->json("Delete Successful",402);
    }

    public function checkSeller(Seller $seller,Product $product)
    {
        if($seller->id != $product->seller_id){
            throw new HttpException(422, 'The specified seller is not the actual seller of the product');
        }
    }
}
