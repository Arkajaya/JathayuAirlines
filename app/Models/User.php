<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        // Prefer role check via Spatie if available, fallback to role_id === 1
        if (method_exists($this, 'hasRole')) {
            try {
                // Check common variants for role name
                if ($this->hasRole('Admin') || $this->hasRole('admin')) {
                    return true;
                }
            } catch (\Exception $e) {
                // ignore and fallback
            }
        }

        // Fallback: resolve role_id to role name if Spatie roles are present
        if ($this->role_id) {
            try {
                $role = \Spatie\Permission\Models\Role::find($this->role_id);
                if ($role && strtolower($role->name) === 'admin') {
                    return true;
                }
            } catch (\Exception $e) {
                // ignore and final fallback
            }
        }

        return false;
    }

    /**
     * Check if the user has a role by name.
     * This overrides Spatie's `hasRole` to also fallback to `role_id` mapping
     * so checks still work if Spatie roles are not yet synced in some environments.
     *
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($roles): bool
    {
        // normalize to array
        $needles = is_array($roles) ? $roles : [$roles];

        // check Spatie role names first (if package available)
        try {
            $assigned = $this->getRoleNames()->toArray();
        } catch (\Throwable $e) {
            $assigned = [];
        }

        foreach ($needles as $needle) {
            if (in_array($needle, $assigned, true)) {
                return true;
            }
        }

        // fallback: try resolve role_id to name
        if ($this->role_id) {
            try {
                $role = \Spatie\Permission\Models\Role::find($this->role_id);
                if ($role && in_array($role->name, $needles, true)) {
                    return true;
                }
            } catch (\Throwable $e) {
                // ignore and continue
            }
        }

        // last resort: case-insensitive match against assigned names
        $lowerAssigned = array_map(fn($v) => strtolower($v), $assigned);
        foreach ($needles as $needle) {
            if (in_array(strtolower((string) $needle), $lowerAssigned, true)) {
                return true;
            }
            if (strtolower((string) $needle) === 'admin' && $this->isAdmin()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convenience: check any of multiple roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $r) {
            if ($this->hasRole($r)) return true;
        }
        return false;
    }

}