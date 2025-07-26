<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "category_id",
        "brand_id",
        "location_id",
        "name",
        "supplier_id",
        "created_at",
        "price_dollar",
        "sale_profit_percentage",
        "discount_only_dollar",
        "stock_available",
        "description",
        "slug",
        "slug_search",
        "slug_name",
        "state",
        "state",
        "user_id"
    ];

    protected $primaryKey = "product_id";

    protected $table = "products";

    public function location()
    {
        return $this->belongsTo(Location::class, "location_id");
    }

    public function goods()
    {
        return $this->hasMany(Good::class, "good_id");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id");
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, "supplier_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
