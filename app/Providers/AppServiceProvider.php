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


    VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        return (new MailMessage)
            ->subject('Regisztráció megerősítése')
            ->greeting("Kedves ".$notifiable->vez_nev." ".$notifiable->ker_nev."!")
            ->line("Köszönjük, hogy regisztrált a WalletMaster weboldalára.")
            ->line('Kérjük, erősítse meg e-mail címét az alábbi gombra kattintva: ')
            ->action('E-mail cím megerősítése', $url)
            ->line("Ha nem Ön regisztrált weboldalunkon, kérjük hagyja figyelmen kívül ezt az üzenetet.")
            ->greeting("Üdvözlettel: A WalletMaster csapata");
    });
    }
}
