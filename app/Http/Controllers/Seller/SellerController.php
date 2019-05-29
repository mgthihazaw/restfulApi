<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Seller;
use App\User;

class SellerController extends ApiController
{
    
    public function index()
    {
        $sellers=Seller::has('products')->get();
        return $this->showAll($sellers,200);
       
    }

 

    public function show(Seller $seller)
    {
        
        // return User::find($id);
        return $this->showOne($seller,200);
    }

  
}
