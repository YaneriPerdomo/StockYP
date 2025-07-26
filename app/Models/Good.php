<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = [
        "good_id",
        "description",
        'created_at' ,
        "user_id"
    ];
    protected $table = 'goods';
    protected $primaryKey = 'good_id';

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function MerchandisesDetails(){
        return $this->hasMany(MerchandisesDetails::class, 'good_id');
    }
       const UPDATED_AT = null;
}
