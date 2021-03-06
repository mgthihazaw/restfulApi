<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {
            
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');

            $table->primary(['category_id','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::enableForeignKeyConstraints();
        Schema::dropIfExists('category_product');
        Schema::disableForeignKeyConstraints();
    }
}
