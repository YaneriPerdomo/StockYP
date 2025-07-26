<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $table = "categorys";
   protected $primaryKey = "category_id";

   protected $fillable = [
      "name",
      "slug",
      "category_id",
      "user_id"
   ];

   public $timestamps = false;

   public function products()
   {
      return $this->hasMany(Category::class, "category_id");
   }

   public function user()
   {
      return $this->belongsTo(User::class, 'user_id');
   }
   public function employee()
   {
      return $this->hasOne(Employee::class, 'user_id');
   }
}
