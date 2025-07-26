<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = "genders";
    protected $fillable = [
        "gender_id",
        "gender"
    ];

    public $timestamps = false;

    protected $primaryKey = "gender_id";

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, "gender_id");
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, "gender_id");
    }
}
