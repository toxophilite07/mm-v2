<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'address',
        'email',
        'contact_no',
        'birthdate',
        'password',
        'menstruation_status',
        'user_role_id',
        'is_active',
        'remarks'
    ];

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
        'password' => 'hashed',
    ];

    public function last_periods() {
        return $this->hasMany(MenstruationPeriod::class)
            ->orderBy('menstruation_date', 'desc')
            ->select(['id', 'user_id', 'menstruation_date', 'remarks', 'created_at']);
    }

    public function full_name() {
        return $this->last_name . ', ' . $this->first_name;
    }

    // public function getFullNameAttribute_health_worker()
    // {
    //     return "{$this->first_name} {$this->last_name}";
    // }

    public function getHealthWorkerFullNameAttribute()
    {
        // Specific format for health workers
        return "{$this->first_name} {$this->last_name}";
    }

    public function menstruationPeriods()
    {
        return $this->hasMany(MenstruationPeriod::class);
    }
}
