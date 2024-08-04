<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getTypeAttribute(){
        
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            // Assign default role to the newly created user
            $defaultRole = \TCG\Voyager\Models\Role::where('name', 'ibu')->first();
            $user->roles()->attach($defaultRole);
            $user->role_id = $defaultRole->id;
            $user->save();
        });
    }

    public function mother(){
        return $this->hasOne(Mother::class, 'user_id', 'id' );
    }

    public function staff(){
        return $this->hasOne(MedicalStaff::class, 'user_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
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
    ];
}
