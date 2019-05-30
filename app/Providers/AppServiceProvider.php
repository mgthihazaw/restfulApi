<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Product;
use App\Transaction;
use App\Mail\UserCreated;
use App\User;
use App\Mail\UserEmailChanged;
use Illuminate\Support\Facades\Mail;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        

       

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::created(function($user){
            retry(5,function() use ($user){
                Mail::to($user)->send(new UserCreated($user));
            },100);
            
        });
        User::updated(function($user){
            if($user->isDirty('email')){
                retry(5,function() use ($user){
                Mail::to($user)->send(new UserEmailChanged($user));
            },100);
            
            }
            
       });
        Product::updated(function($product){
            if($product->quantity == 0 && $product->isAvaiable()){
                
                $product->status =Product::UNAVAIABLE_PRODUCT;
                $product->save();
            }
        //    if($product->quantity > 0 && !$product->isAvaiable()){
        //         $product->status =Product::AVAIABLE_PRODUCT;
        //         $product->save();
        //     }
           
        });
        // Transaction::saved(function($product){
        //         dd("Hello Save");
                
        //     });
    }
}
