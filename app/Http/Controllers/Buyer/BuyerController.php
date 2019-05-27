<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Buyer;


class BuyerController extends Controller
{
    
    public function index()
    {
        $buyers=Buyer::has('transactions')->get();

        return response()->json(['data' =>$buyers],200);
    }

    public function show(Buyer $buyer)
    {
        return response()->json(['data' => $buyer],200);
    }


}
