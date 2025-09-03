<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'market_id',
        'story_id',
        'title',
        'word_count',
        'notes',
        'submitted_at',
        'status',
        'response_date',
        'response_notes',
        'payment_amount',
        'payment_currency',
        'payment_date',
    ];

    protected $casts = [
        'submitted_at' => 'date',
        'response_date' => 'date',
        'payment_date' => 'date',
        'payment_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('submitted_at', '>=', now()->subDays($days));
    }
}
