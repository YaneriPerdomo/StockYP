<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;

class Brand extends Model
{
    protected $table = "brands";
    protected $primaryKey = "brand_id";

    protected $fillable = [
        "name",
        "slug",
        "user_id",
        "brand_id"
    ];

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

    public $timestamps = false;

}
