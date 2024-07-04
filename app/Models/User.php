<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Report;
use App\Models\Requesting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'title',
        'address',
        'civic_code',
        'zip_code',
        'phone',
        'mobile',
        'emergency_person1',
        'emergency_phone1',
        'emergency_person1_relationship',
        'emergency_person2',
        'emergency_phone2',
        'emergency_person2_relationship',
        'cv',
        'profil',
        'gender'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function member()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
