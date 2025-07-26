<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityCard extends Model
{
    protected $table = "identity_cards";
    protected $fillable = [
        "identity_card",
        "identity_card_id",
        "description",
        "letter",
    ];

    protected $primaryKey = "identity_card_id";

    public function customers()
    {
        return $this->hasMany(Customer::class, "identity_card_id");
    }
}
