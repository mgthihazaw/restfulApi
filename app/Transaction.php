<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Buyer;
use Illuminate\Database\Eloquent\softDeletes;

class Transaction extends Model
{
    use softDeletes;
    protected $dates=['deleted_at'];
    protected $fillable= [
        'quantity',
        'buyer_id',
        'product_id',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }
    
}
