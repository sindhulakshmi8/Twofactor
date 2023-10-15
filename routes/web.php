<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/2fa', function () {
    return view('2fa');
});

Route::post('/2fa', function (Request $request) {
    $request->validate([
        'token' => 'required',
    ]);

    if($request->input('token') == Auth::user()->two_factor_token){            
        $user = Auth::user();
        $user->two_factor_expiry = \Carbon\Carbon::now()->addMinutes(config('session.lifetime'));
        $user->save();

        return redirect()->intended('home');
    } else {
        return redirect('/2fa')->with('message', 'Incorrect code.');
    }
});

Route::get('/2fa', [App\Http\Controllers\TwoFactorController::class, 'show2faForm']);
Route::post('/2fa', [App\Http\Controllers\TwoFactorController::class, 'verifyToken']);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('two_factor_auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
    Route::post('change-password', [App\Http\Controllers\HomeController::class, 'doChangePassword'])->name('change-password');

});
Route::get('/passwordExpiration',[App\Http\Controllers\PwdExpirationController::class, 'showPasswordExpirationForm']);
Route::post('/passwordExpiration',[App\Http\Controllers\PwdExpirationController::class, 'postPasswordExpiration'])->name('passwordExpiration');
Auth::routes();
