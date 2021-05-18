<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectionTest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['completed_at'];

    public function getCompletedAttribute(): bool
    {
        return $this->completed_at !== null;
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }
}
