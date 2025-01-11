<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('usuario.profile', compact('user'));
    }

    public function verifyEmail()
    {
        $user = auth()->user();

        if ($user->email_verified_at) {
            return redirect()->route('profile')
                ->with("warning_title", "Correo electrónico ya verificado")
                ->with("warning_message", "Tu correo electrónico ya ha sido verificado.");
        }
        return view('usuario.email', compact('user'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        if ($user->role === "admin") {
            return redirect()->route('admin.profile')
                ->with("success_title", "Contraseña actualizada")
                ->with("success_message", "Tu contraseña ha sido actualizada correctamente.");
        } else {
            return redirect()->route('profile')
                ->with("success_title", "Contraseña actualizada")
                ->with("success_message", "Tu contraseña ha sido actualizada correctamente.");
        }
    }

    public function admin()
    {
        $user = auth()->user();
        $maintenance = Setting::where('key', 'maintenance')->first();
        $project_mode = Setting::where('key', 'project_mode')->first();
        $question_mode = Setting::where('key', 'question_mode')->first();
        return view('admin.profile', [
            'user' => $user,
            'maintenance' => $maintenance,
            'project_mode' => $project_mode,
            'question_mode' => $question_mode,
        ]);
    }
}