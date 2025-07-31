<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $table = "saving";
    protected $primaryKey = "saving_id";

    protected $fillable = [
        "value",
        "slug",
        "saving_id  ",
        "user_id"
    ];

    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
