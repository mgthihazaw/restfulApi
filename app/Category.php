<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\softDeletes;

class Category extends Model
{
    use softDeletes;
    
    protected $date=['deleted_at'];
    protected $fillable=[
        'name',
        'description'
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }
    
}
