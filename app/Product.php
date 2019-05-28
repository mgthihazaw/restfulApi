<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;
use App\Transaction;
use Illuminate\Database\Eloquent\softDeletes;

class Product extends Model
{
    use softDeletes;
    protected $dates=['deleted_at'];
    const AVAIABLE_PRODUCT='avaiable';
    const UNAVAIABLE_PRODUCT = 'unavaiable';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    public function isAvaiable(){
        return $this->status == Product::AVAIABLE_PRODUCT;
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    protected $hidden = ['pivot','deleted_at'];
}
