<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class)->orderBy('id', 'desc');
    }

    public function information()
    {
        return $this->hasMany(Information::class)->orderBy('id', 'desc');
    }

    public function Transactions()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentsSuccess()
    {
        return $this->hasMany(Payment::class)->where('status_code', '00')->orderBy('id', 'desc');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('id', 'desc');
    }

    public function scopeFilter($query)
    {
        if (request('search')) {
            return $query->where('id', 'LIKE', '%' . request('search') . '%')->orWhere('name', 'LIKE', '%' . request('search') . '%');
        }
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    public function scopeShown($query)
    {
        return $query->where('is_shown', true);
    }

    public function scopeHidden($query)
    {
        return $query->where('is_shown', false);
    }

    public function scopeLimitedTime($query)
    {
        return $query->where('is_time_limit', true);
    }

    public function scopeWithoutTargetAmount($query)
    {
        return $query->where('is_target', false);
    }

    public function scopeTargetAmount($query)
    {
        return $query->where('is_target', true);
    }
}
