<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchandiseHistory extends Model
{
    protected $table = "merchandise_history";

    protected $primaryKey = "merchandise_history_id";
    protected $fillable = [
        "return_merchandise_id",
        "good_id",
        "merchandise_history_id",
        "message",
        "created_at"
    ];

    public $timestamps = true;

}
