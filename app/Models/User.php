<?php

namespace App\Models;

use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Contracts\Role;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Vormkracht10\TwoFactorAuth\Enums\TwoFactorType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;

    const ROLE_SUPERADMIN = 'SUPERADMIN';
    const ROLE_MANAGERADMIN = 'MANAGERADMIN';
    const ROLE_ADMINESD = 'ADMINESD';
    const ROLE_ADMINUTILITY = 'ADMINUTILITY';
    const ROLE_ADMINHR = 'ADMINHR';
    const ROLE_ADMINGA = 'ADMINGA';
    const ROLE_SECURITY = 'SECURITY';
    const ROLE_USER = 'USER';

    const ROLES = [
        self::ROLE_SUPERADMIN => 'SuperAdmin',
        self::ROLE_MANAGERADMIN => 'Manager Admin',
        self::ROLE_ADMINESD => 'Admin ESD',
        self::ROLE_ADMINUTILITY => 'Admin Utility',
        self::ROLE_ADMINHR => 'Admin HR',
        self::ROLE_ADMINGA => 'Admin GA',
        self::ROLE_SECURITY => 'Security',
        self::ROLE_USER => 'User',
    ];

    protected $fillable = [
        'nik',
        'name',
        'department',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'two_factor_type' => TwoFactorType::class,
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $panelId = $panel->getId();

        if ($this->role == self ::ROLE_SUPERADMIN) {
            return true;
        }
        

        switch ($panelId) {
            case 'esd':
                return $this->role === self::ROLE_ADMINESD || self::ROLE_USER;
            case 'hr':
                return $this->role === self::ROLE_ADMINHR || self::ROLE_SECURITY;
            case 'ga':
                return $this->role === self::ROLE_ADMINGA;
            case 'utility':
                return $this->role === self::ROLE_ADMINUTILITY;
            case 'stock':
                return !$this->role == self::ROLE_USER || self::ROLE_SECURITY; // All roles except USER
            default:
                return false;
        }
    }

    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    public function isManagerAdmin()
    {
        return $this->role === self::ROLE_MANAGERADMIN;
    }

    public function isAdminEsd()
    {
        return $this->role === self::ROLE_ADMINESD;
    }

    public function isAdminUtility()
    {
        return $this->role === self::ROLE_ADMINUTILITY;
    }

    public function isAdminHr()
    {
        return $this->role === self::ROLE_ADMINHR;
    }

    public function isAdminGa()
    {
        return $this->role === self::ROLE_ADMINGA;
    }

    public function isSecurity()
    {
        return $this->role === self::ROLE_SECURITY;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }
}