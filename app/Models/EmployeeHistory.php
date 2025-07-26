<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeHistory extends Model
{
    protected $table = "employees_history";

    protected $primaryKey = "employee_history_id";

    protected $fillable = [
        "created_at",
        "user_id",
        "description",
        "employee_history_id"
    ];

    const UPDATED_AT = null;


    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
