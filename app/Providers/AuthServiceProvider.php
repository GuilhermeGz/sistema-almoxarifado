<?php

namespace App\Providers;

use App\Usuario;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('update-usuario', function ($user, $usuario) {
            return ($user->id == $usuario) || 1 == $user->cargo_id;
        });

        Gate::define('read-usuario', function ($user) {
            return 1 == $user->cargo_id;
        });

        VerifyEmail::toMailUsing(function (Usuario $user, string $verificationUrl) {
            return (new MailMessage())
                ->subject(Lang::get('Verificar endereço de e-mail'))
                ->line(Lang::get('Clique no botão abaixo para verificar o seu endereço de e-mail.'))
                ->action(Lang::get('Verificar endereço de e-mail'), $verificationUrl)
                ->line(Lang::get('Se você não criou uma conta, nenhuma ação adicional é necessária.'))
            ;
        });
    }
}
