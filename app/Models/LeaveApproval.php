<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LeaveApproval extends Model
{
    protected $fillable = [
        "leave_id",
        "approver_id",
        "notes",
        "status"
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class, );
    }

    public function approver()
    {
        return $this->belongsTo(User::class, "approver_id");
    }
}
