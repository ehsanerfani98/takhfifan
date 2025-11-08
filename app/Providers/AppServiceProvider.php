<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

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
        Config::set('mail.mailers.smtp.transport', get_setting('mail_mailer'));
        Config::set('mail.mailers.smtp.host', get_setting('mail_host'));
        Config::set('mail.mailers.smtp.port', get_setting('mail_port'));
        Config::set('mail.mailers.smtp.username', get_setting('mail_username'));
        Config::set('mail.mailers.smtp.password', get_setting('mail_password'));
        Config::set('mail.mailers.smtp.encryption', get_setting('mail_encryption'));
        Config::set('mail.from.address', get_setting('mail_from_address'));
        Config::set('mail.from.name', get_setting('mail_from_name'));

        
    }
}
