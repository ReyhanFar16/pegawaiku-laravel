<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [
        "name",
        "max_days",
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
