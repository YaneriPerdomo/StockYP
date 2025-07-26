<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employees";

    protected $primaryKey = "employee_id";

    protected $fillable = [
        "employee_id",
        "gender_id",
        "identity_card_id",
        "user_id",
        "name",
        "lastname",
        "telephone_number",
        "address",
        "slug",
        "created_at"
    ];

        const UPDATED_AT = null;

    public function identityCard()
    {
        return $this->belongsTo(IdentityCard::class, "identity_card_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, "gender_id");
    }

    public $timestamps = true;
}
