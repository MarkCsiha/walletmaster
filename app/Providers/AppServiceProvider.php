<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

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
        //

    //https://www.youtube.com/watch?v=FDwq3HZds68
    VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        return (new MailMessage)
           ->view('auth.verify-email', [
            'user'  => $notifiable,
            'url'   => $url
           ]);
    });
    }
}
