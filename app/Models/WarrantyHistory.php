<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyHistory extends Model
{
    protected $table = "warranty_history";

    protected $primaryKey = "warranty_history_id";
    protected $fillable = [
        "sale_id",
        "message",
        "warranty_history_id",
        "created_at",
        "updated_at"
    ];

    
}
