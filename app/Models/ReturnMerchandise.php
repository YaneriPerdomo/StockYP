<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnMerchandise extends Model
{

    protected $fillable = [
        "return_merchandise_id",
        "description",
        'created_at',
        'user_id'
    ];
    protected $table = 'return_merchandise';
    protected $primaryKey = 'return_merchandise_id';

   
    public function ReturnMerchandiseDetails()
    {
        return $this->hasMany(ReturnMerchandiseDetails::class, 'return_merchandise_id');
    }
    const UPDATED_AT = null;
}
