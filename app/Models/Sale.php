<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        "sale_id",
        "customer_id",
        "payment_type_id",
        "receipt_number",
        "total_price_dollars",
        "total_price_bs",
        "exchange_rate_bs",
        "credit_rate",
        "status",
        "tax_base",
        "expiration_date",
        "remarks",
        "created_at",
        "updated_at",
        "slug",
        "paid_only_dollars",
        "total_amount_paid_bs",
        "user_id",
    ];

    protected $primaryKey = "sale_id";

    protected $table = "sales";

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id");
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, "payment_type_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function salesDetails()
    {
        return $this->hasMany(SaleDetails::class, "sale_id");
    }
}
