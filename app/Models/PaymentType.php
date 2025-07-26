<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $fillable = [
        "payment_type_id",
        "name",
    ];

    protected $primaryKey = "payment_type_id";

    protected $table = "payment_types";

    public $timestamps = false;
}
