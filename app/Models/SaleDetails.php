<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model {

    protected $fillable = [
        "sale_detail_id",
        "sale_id",
        "product_id",
        "quantity",
        "unit_cost_dollars",
        "subtotal_dollars",
        "discount",
        "created_at",
        "updated_at",
        "warranty_status"
    ];

    protected $primaryKey = "sale_detail_id";

    protected $table = "sales_details";

      public function products(){
         return $this->belongsTo(Product::class, "product_id");
    }
    
    public function sale(){
         return $this->belongsTo(Sale::class, "sale_id");
    }
}
