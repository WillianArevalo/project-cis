<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function validate(LoginRequest $request)
    {
        $credentials = $request->only('user', 'password');
        $remember = $request->has("remember");

        if (auth()->attempt($credentials, $remember)) {
            $user = auth()->user();

            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with("success_title", "Bienvenido")
                    ->with("success_message", "Has iniciado sesión correctamente.");
            }

            return redirect()->route('home')
                ->with("success_title", "Bienvenido")
                ->with("success_message", "Has iniciado sesión correctamente.");
        }

        return redirect()->route('login')
            ->with('error_title', 'Error de autenticación')
            ->with('error_message', 'Las credenciales ingresadas son incorrectas.')
            ->withInput();
    }


    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->back();
    }

    public function forgotPassword()
    {
        return view('reset-password.send');
    }

    public function emailResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('forgot-password')
                ->with('error_title', 'Error al enviar correo')
                ->with('error_message', 'El correo ingresado no se encuentra registrado.');
        }

        try {
            DB::beginTransaction();
            $token = Str::random(60);
            $url = route('reset-password', ['token' => $token]);
            $user->remember_password_token = $token;
            $user->password_token_expires_at = now()->addMinutes(10);
            $user->email = $request->email;
            $user->save();
            $user->sendEmailResetPassword($token, $user->name, $url, $request->email);
            DB::commit();
            return redirect()->route('confirm-send-email-reset-password')
                ->with('success_title', 'Correo electrónico enviado')
                ->with('success_message', 'Se ha enviado un correo electrónico a la dirección proporcionada.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('forgot-password')
                ->with('error_title', 'Error al enviar correo')
                ->with('error_message', 'Ocurrió un error al enviar el correo electrónico.');
        }
    }

    public function confirmSendEmailResetPassword()
    {
        return view('reset-password.confirm');
    }

    public function resetPassword(Request $request)
    {
        $token = $request->query('token');
        $user = User::where('remember_password_token', $token)->first();
        if (!$user) {
            return redirect()->route('forgot-password')
                ->with('error_title', 'Token inválido o expirado')
                ->with('error_message', 'El token proporcionado es inválido o ha expirado.');
        }

        return view('reset-password.form', compact('token'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'confirm_password' => 'required|string'
        ]);

        $user = User::where('remember_password_token', $request->token)->first();
        if (!$user) {
            return redirect()->route('forgot-password')
                ->with('error_title', 'Token inválido o expirado')
                ->with('error_message', 'El token proporcionado es inválido o ha expirado.');
        }

        $user->password = Hash::make($request->password);
        $user->remember_password_token = null;
        $user->password_token_expires_at = null;
        $user->save();

        return redirect()->route('login')
            ->with('success_title', 'Contraseña actualizada')
            ->with('success_message', 'Tu contraseña ha sido actualizada correctamente.');
    }
}
