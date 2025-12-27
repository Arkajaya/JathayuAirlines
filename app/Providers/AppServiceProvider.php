<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure existing users with role_id are assigned corresponding Spatie roles
        try {
            if (class_exists(Role::class)) {
                // map role_id to role name (adjust if your app uses different ids)
                $mapping = [
                    1 => ['Admin'],
                    2 => ['Staff'],
                    3 => ['User'],
                ];

                foreach ($mapping as $roleId => $names) {
                    $users = User::where('role_id', $roleId)->get();
                    foreach ($users as $u) {
                        foreach ($names as $rname) {
                            if (! $u->hasRole($rname)) {
                                try {
                                    $u->assignRole($rname);
                                } catch (\Exception $e) {
                                    // ignore assign errors (role may not exist)
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::debug('Role sync skipped: '.$e->getMessage());
        }
    }
}
