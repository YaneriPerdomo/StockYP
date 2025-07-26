<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnMerchandiseDetails extends Model
{
    protected $table = "return_merchandise_details";

    protected $primaryKey = "return_merchandise_details_id";
    protected $fillable = [
        "return_merchandise_details_id",
        "return_merchandise_id",
        "product_id",
        "amount",
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
