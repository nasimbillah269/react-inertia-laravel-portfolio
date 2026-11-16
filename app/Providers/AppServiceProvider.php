<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // API tokens aren't used — don't create the personal_access_tokens table
        \Laravel\Sanctum\Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mail / social settings come from the `generals` table. Skip when it doesn't exist yet
        // (e.g. `php artisan migrate` on a fresh database), otherwise every artisan command fails.
        if (\Illuminate\Support\Facades\Schema::hasTable('generals')) {
            $this->applyGeneralSettings();
        }

        Inertia::share([
            'flash' => function () {
                return [
                    'success' => session('success'),
                    'error' => session('error'),
                ];
            },
        ]);
    }

    protected function applyGeneralSettings(): void
    {
        \Config::set("services.facebook.client_id", general()->fb_app_id);
        \Config::set("services.facebook.client_secret", general()->fb_app_secret);
        \Config::set("services.facebook.redirect", general()->fb_app_secret);

        \Config::set("services.google.client_id", general()->google_client_id);
        \Config::set("services.google.client_secret", general()->google_client_secret);
        \Config::set("services.google.redirect", general()->google_client_redirect_url);
        
        \Config::set("mail.mailers.smtp.transport", general()->mail_driver);
        \Config::set("mail.mailers.smtp.host", general()->mail_host);
        \Config::set("mail.mailers.smtp.port", general()->mail_port);
        \Config::set("mail.mailers.smtp.encryption", general()->mail_encryption);
        \Config::set("mail.mailers.smtp.username", general()->mail_username);
        \Config::set("mail.mailers.smtp.password", general()->mail_password);
    }
}
