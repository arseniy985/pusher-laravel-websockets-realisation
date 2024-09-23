<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function showLoginForm(): View
    {
        return view('user.login');
    }

    public function showRegisterForm(): View
    {
        return view('user.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = [
            'login' => $request->login,
            'password' => Hash::make($request->password),
        ];
        $user = User::create($data);
        Auth::login($user, true);

        return redirect()->route('home.index');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if(Auth::attempt($request->only(['login', 'password']), true)) {
            return redirect()->route('home.index');
        };

        return redirect()->back()->withErrors([403 => 'Неправильный логин или пароль']);
    }
}
