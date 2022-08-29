<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // private $signup = "merci de vous être inscrit sur notre site Web, 
    // pour terminer nous devons d'abord confirmer votre e-mail. 
    // Veuillez cliquer sur le bouton de vérification ci-dessous.";
    public function show_login()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'password' => ['required']
        ]);
        $user = User::get_by_name($request->input('name'));
        if (!$user)
            return back()->withErrors([
                'notice' => 'le nom ou le mot de pass est incorrect'
            ])->withInput();
        if (Hash::check($request->input('password'), $user->password)) {
            Auth::loginUsingId($user->id, $request->has('remember_me'));
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        } else
            return back()->withErrors([
                'notice' => 'le nom ou le mot de pass est incorrect'
            ])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect(route('home'));
    }
    public function forgot_password()
    {
        return view('auth.forgot-password');
    }
    public function handle_forgot_password(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::get_by_email($request->input('email'));
        if (!$user) {
            return back()->withErrors([
                'email' => "Nous ne trouvons pas d'utilisateur avec cette adresse e-mail."
            ]);
        }
        $hash = Str::random(random_int(32, 60));
        User::simple_update($user->id, [
            'password_reset_hash' => $hash,
            'password_reset_hash_created_at' => now()
        ]);
        Mail::to($user->email)->send(new PasswordReset(route('show_reset-password', [
            'id' => $user->id,
            'hash' => $hash
        ])));
        return redirect(route('login'))->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'on vous a envoyé un email de confirmation, consultez votre email'
            ]
        ]);
    }
    public function show_reset_password($id, $hash)
    {
        $user = User::get($id, false);
        if (!$user || $user->password_reset_hash != $hash) {
            return redirect(route('password.request'))
                ->with([
                    'alert' => (object) [
                        'type' => 'error',
                        'message' => 'lien invalide'
                    ]
                ]);
        }
        $start = Carbon::parse($user->password_reset_hash_created_at);
        $end = Carbon::parse(now());
        $hours = $end->diffInHours($start);
        if ($hours > 24) {
            return redirect(route('password.request'))
                ->with([
                    'alert' => (object) [
                        'type' => 'error',
                        'message' => 'le lien est expiré'
                    ]
                ]);
        }
        return view('auth.reset-password', [
            'id' => $user->id
        ]);
    }
    public function reset_password(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);
        User::simple_update($id, [
            'password' => Hash::make($request->input('password')),
            'password_reset_hash' => null,
            'password_reset_hash_created_at' => null
        ]);
        return redirect(route('login'))->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'votre mot de passe a été changé, connectez vous'
            ]
        ]);
    }
    public function set_session(Request $request)
    {
        $key = $request->all()['key'];
        $value = $request->all()['value'];
        session()->put($key, $value);
        return response(status: 201);
    }
}