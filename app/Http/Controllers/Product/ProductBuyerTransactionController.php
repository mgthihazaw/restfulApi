<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    
    public function store(Request $request,Product $product ,User $buyer)
    {
         $rules = [
            
            'quantity' =>'required|integer|min:1'
           
        ];
        // return $product->seller;
        // $this->validate($request,$rules);
        // if($buyer->id == $product->seller->id) {
        //     return $this->errResponse('The buyer must be different from the seller ',409);
        // }
        // // dd($buyer->isVerified());
        // if(!$buyer->isVerified()){
        //     return $this->errResponse('The buyer must be a verified user',409);
        // }
        // if(!$product->isAvaiable()){
        //     return $this->errResponse('This product is not avaiable',409);
        // }
        // if($product->quantity < $request->quantity){
        //     return $this->errResponse('The product does not have enough units for this transaction');
        // }

        // return DB::transaction(function() use ($request,$product,$buyer){
            $product->quantity -= $request->quantity;
            
            $product->update(['quantity' => $product->quantity]);
            // return "Hello";
            $transaction = Transaction::create([
                'quantity'=>$request->quantity,
                'buyer_id' =>$buyer->id,
                'product_id' =>$product->id,
            ]);
            return $this->showOne($transaction,201);
        // });
    }

   
}
