<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleRepair extends Model
{
    protected $table = "sales_repair";
    protected $fillable = [
        "sale_repair_id",
        "sale_id",
        "comments",
        "technical_manager",
        "estimated_completion_date"
    ];

    protected $primaryKey = "sale_repair_id";

}
