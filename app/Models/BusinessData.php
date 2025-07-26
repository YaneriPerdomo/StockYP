<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessData extends Model
{
   protected $table = "business_data";
   protected $primaryKey = "business_data_id";

   protected $fillable = [
      "name",
      "phone",
      "email",
      "updated_at",
      "address",
      "rif",
      "identity_card_id"
   ];

   public function identityCard()
   {
      return $this->belongsTo(IdentityCard::class, "identity_card_id");
   }

   public $timestamps = true;
}
