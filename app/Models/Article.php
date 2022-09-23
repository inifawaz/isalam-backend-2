<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function scopeShown($query)
    {
        return $query->where('is_shown', true);
    }
}
