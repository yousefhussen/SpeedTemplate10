<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Entities\TempToken;
use Modules\Auth\Entities\User;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'consent'])->stateless()
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    public function callback(Request $request)
    {
        try {


            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]
            );
            \Auth::login($user);

            return redirect()->away(
                config('app.frontend_url') . '/'
            );

        } catch (\Exception $e) {

            \Log::error('Google Auth Error: ' . $e->getMessage());

            return redirect()->away(
                config('app.frontend_url') . '/?error=' . urlencode($e->getMessage())
            );
        }
    }
}
