<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function validate(LoginRequest $request)
    {
        $credentials = $request->only('user', 'password');
        $user = User::where("user", $credentials['user'])->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error_title', 'Error de autenticación')
                ->with('error_message', 'Las credenciales ingresadas son incorrectas.');
        }

        if (!Hash::check($credentials["password"], $user->password)) {
            return redirect()->route('login')
                ->with("error_title", "Error de autenticación")
                ->with("error_message", "Las credenciales ingresadas son incorrectas.");
        }

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with("success_title", "Bienvenido")
                    ->with("success_message", "Has iniciado sesión correctamente.");
            }
            return redirect()->route('home');
        }

        Auth::login($user);
        if ($user->role != "admin") {
            return redirect()->route("home")
                ->with("success_title", "Bienvenido")
                ->with("success_message", "Has iniciado sesión correctamente.");
        } else {
            return redirect()->route("admin.dashboard')")
                ->with("success_title", "Bienvenido")
                ->with("success_message", "Has iniciado sesión correctamente.");
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->back();
    }
}