<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use App\Mail\TwoFactorAuthMail;
use Auth;

class TwoFactorVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
if ($user->two_factor_expiry > \Carbon\Carbon::now()) {
    return $next($request);
}
$ran = str::random(10);
$user->two_factor_token = $ran;
$user->save();

\Mail::to($user)->send(new TwoFactorAuthMail($user->two_factor_token));

return redirect('/2fa');
    }
}
