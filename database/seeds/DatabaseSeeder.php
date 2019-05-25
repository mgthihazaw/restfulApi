<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use App\Seller;
use App\Buyer;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        // DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // User::truncate();
        // Category::truncate();
        // Product::truncate();
        // Transaction::truncate();
        // DB::table('category_product')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        /* ABOVE OR BELOW is the same */
        
        DB::table('users')->delete();
        DB::table('categories')->delete();
        DB::table('products')->delete();
        DB::table('transactions')->delete();

        DB::table('category_product')->delete();
        

        $uq=200;
        $cq=30;
        $pq=100;
        $tq= 1000;

        factory(User::class,$uq)->create();
        factory(Category::class,$cq)->create();
        factory(Product::class,$pq)->create()->each(
            function ($product){
                $categories = Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            }
        );
        factory(Transaction::class,$tq)->create();
    }
}
