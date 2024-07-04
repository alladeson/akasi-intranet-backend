<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory; 
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'starting_date',
        'estimated_time',
        'tools',
        'status'
    ];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
