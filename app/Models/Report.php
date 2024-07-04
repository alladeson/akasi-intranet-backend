<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'goals',
        'achievements',
        'observations',
        'next_goals',
        'status',
        'validated',
        'pdf',
        'user_id',
    ];

    protected $casts = [
        'goals' => 'array',
        'achievements' => 'array',
        'observations' => 'array',
        'next_goals' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
