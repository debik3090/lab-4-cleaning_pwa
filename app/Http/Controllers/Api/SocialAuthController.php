<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SocialAccount; // если есть отдельная модель привязки соцсетей
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // 1) Отдаём фронту URL для редиректа
    public function redirect(string $provider)
{
    $supported = ['github', 'google', 'vkontakte'];
    if (! in_array($provider, $supported, true)) {
        abort(400, 'Unsupported provider');
    }

    return Socialite::driver($provider)
        ->stateless()
        ->redirect();
}


    // 2) Callback от провайдера: создаём/находим пользователя, логиним, редиректим в SPA
    public function callback(string $provider)
    {
        $supported = ['github', 'google', 'vkontakte'];
        if (! in_array($provider, $supported, true)) {
            abort(400, 'Unsupported provider');
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Throwable $e) {
            // В случае ошибки — редирект на SPA с сообщением
            return redirect(config('app.frontend_url', 'http://localhost:5173') . '/profile?error=social');
        }

        // Здесь логика поиска/создания пользователя
        // Упростим: ищем по email, если нет — создаём
        $email = $socialUser->getEmail();
        $name = $socialUser->getName() ?: $socialUser->getNickname();

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name ?: 'User',
                'password' => bcrypt(str()->random(16)),
            ]
        );

        // Если есть отдельная модель SocialAccount, можно записать привязку провайдера
        if (class_exists(SocialAccount::class)) {
            SocialAccount::updateOrCreate(
                [
                    'provider'    => $provider,
                    'provider_id' => $socialUser->getId(),
                ],
                [
                    'user_id' => $user->id,
                ]
            );
        }

        // Логиним пользователя через стандартную сессию (для Sanctum SPA)
        Auth::login($user, true);

        // Редиректим обратно в SPA (на профиль, например)
        $frontend = config('app.frontend_url', 'http://localhost:5173');

        return redirect($frontend . '/profile');
    }
}
