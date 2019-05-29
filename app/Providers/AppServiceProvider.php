<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Product;
use App\Transaction;
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
