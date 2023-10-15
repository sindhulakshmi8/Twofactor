<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordHistory;
use App\Models\PasswordSecurity;
use Hash;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         return view('home');
    }
    public function changePassword(Request $request) {
        $title = 'Change Password';
        return view('change_password', compact('title'));
    }

    public function doChangePassword(Request $request) {

    if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
        // The passwords matches
        return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
    }

    if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //Current password and new password are same
        return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
    }

    $validatedData = $request->validate([
        'current-password' => 'required',
        'new-password' => 'required|string|min:6',
    ]);

    //Check Password History
    $user = Auth::user();
    $passwordHistories = $user->passwordHistories()->take(env('PASSWORD_HISTORY_NUM'))->get();
    foreach($passwordHistories as $passwordHistory){
        echo $passwordHistory->password;
        if (Hash::check($request->get('new-password'), $passwordHistory->password)) {
            // The passwords matches
            return redirect()->back()->with("error","Your new password can not be same as any of your recent passwords. Please choose a new password.");
        }
    }


    //Change Password

    $user->password = bcrypt($request->get('new-password'));
    $user->save();

    //entry into password history
    $passwordHistory = PasswordHistory::create([
        'user_id' => $user->id,
        'password' => bcrypt($request->get('new-password'))
    ]);

    $passwordSecurity = PasswordSecurity::create([
        'user_id' => $user->id,
        'password_expiry_days' => 30,
        'password_updated_at' => Carbon::now(),
    ]);

    return redirect()->back()->with("success","Password changed successfully !");


    }
}
