<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchandisesDetails extends Model
{
    protected $table = "merchandises_details";

    protected $primaryKey = "merchandise_detail_id";
    protected $fillable = [
        "merchandise_detail_id",
        "good_id",
        "product_id",
        "amount",
    ];

    public $timestamps = false;

    public function products (){
         return $this->belongsTo(Product::class, 'product_id');
    }
}
