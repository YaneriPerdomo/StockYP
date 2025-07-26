<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        "customer_id",
        "name",
        "lastname",
        "identity_card_id",
        "gender_id",
        "card",
        "slug",
        "phone",
        "address",
        "user_id",
        "description"
    ];
    protected $table = "customers";
    protected $primaryKey = "customer_id";

    public $timestamps = true;
    public function identityCard()
    {
        return $this->belongsTo(IdentityCard::class, "identity_card_id");
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, "gender_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

