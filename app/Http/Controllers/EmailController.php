<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            DB::beginTransaction();
            $user = auth()->user();
            $token = Str::random(60);
            $url = route('verifyEmail', ['token' => $token]);
            $user->remember_email_token = $token;
            $user->email_token_expires_at = now()->addMinutes(10);
            $user->email = $request->email;
            $user->save();
            $user->sendEmailVerification($token, $user->scholarship->name, $url, $request->email);
            DB::commit();
            return redirect()->route('profile')
                ->with('success_title', 'Correo electrónico enviado')
                ->with('success_message', 'Se ha enviado un correo electrónico a la dirección proporcionada');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al enviar el correo electrónico');
        }
    }

    function verifyEmail(Request $request)
    {
        $token = $request->query('token');
        $user = auth()->user();
        if (
            $user->remember_email_token === $token &&
            $user->email_token_expires_at &&
            Carbon::now()->lessThanOrEqualTo($user->email_token_expires_at)
        ) {
            $user->email_verified_at = now();
            $user->save();
            return redirect()->route("profile")
                ->with("success_title", "Correo electrónico verificado")
                ->with("success_message", "Tu correo electrónico ha sido verificado correctamente.");
        }

        // Token inválido o expirado
        return redirect()->route('profile')
            ->with("error_title", "Token inválido o expirado")
            ->with("error_message", "El token proporcionado es inválido o ha expirado.");
    }
}