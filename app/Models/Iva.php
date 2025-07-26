<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iva extends Model
{
    protected $table = "iva";
    protected $primaryKey = "iva_id";

    protected $fillable = [
        "iva",
        "updated_at",
        "user_id"
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
