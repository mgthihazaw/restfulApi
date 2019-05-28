<?php

use Illuminate\Http\Request;

// Buyers
Route::resource('buyers','Buyer\BuyerController',['only' => ['index','show']]);
// Sellers
Route::resource('sellers','Seller\SellerController',['only' => ['index','show']]);
// Categories
Route::resource('categories','Category\CategoryController',['except' => ['create','edit']]);
//Products
Route::resource('products','Product\ProductController',['only'=>['index','show']]);
//Transactions
Route::resource('transactions','Transaction\TransactionController',['only' => ['index','show'],'show']);
//Users
Route::resource('users','User\UserController',['except' => ['create','edit']]);