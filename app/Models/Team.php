<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'project_id'
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
