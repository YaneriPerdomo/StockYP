<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "locations";
    protected $primaryKey = "location_id";

     protected $fillable = [
        "name",
        "slug",
        "location_id",
        "user_id"
     ];

     public $timestamps = false;

     public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'user_id');
    }
     public function products()
   {
      return $this->hasMany(Location::class, "location_id");
   }
}
