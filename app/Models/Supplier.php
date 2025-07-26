<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "suppliers";
    protected $fillable = [
        "gender_id",
        "supplier_id",
        "name",
        "identity_card_id",
        "card",
        "telephone_number",
        "address",
        'slug',
        'created_at',
        "user_id",
        "state"
    ];

    protected $primaryKey = "supplier_id";

    const UPDATED_AT = null;

    public function gender()
    {
        return $this->belongsTo(Gender::class, "gender_id");
    }

    public function identityCard()
    {
        return $this->belongsTo(IdentityCard::class, "identity_card_id");
    }
    public function products()
    {
        return $this->hasMany(Supplier::class, "supplier_id");
    }


     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

}
