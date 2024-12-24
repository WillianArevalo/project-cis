<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);
        try {
            DB::beginTransaction();
            if ($request->key === "maintenance") {
                $config = Setting::where('key', 'maintenance')->first();
                if ($config->value == 0) {
                    $config->update([
                        'value' => 1
                    ]);

                    DB::commit();
                    return redirect()->route('admin.profile')
                        ->with("success_title", "Configuración actualizada")
                        ->with("success_message", "Modo mantenimiento activado correctamente.");
                } else {
                    $config->update([
                        'value' => 0
                    ]);

                    DB::commit();
                    return redirect()->route('admin.profile')
                        ->with("success_title", "Configuración actualizada")
                        ->with("success_message", "Modo mantenimiento desactivado correctamente.");
                }
            } elseif ($request->key === "project_mode") {
                $config = Setting::where('key', 'project_mode')->first();
                if ($config->value == 0) {
                    $config->update([
                        'value' => 1
                    ]);

                    DB::commit();
                    return redirect()->route('admin.profile')
                        ->with("success_title", "Configuración actualizada")
                        ->with("success_message", "Modo proyecto activado correctamente.");
                } else {
                    $config->update([
                        'value' => 0
                    ]);

                    DB::commit();
                    return redirect()->route('admin.profile')
                        ->with("success_title", "Configuración actualizada")
                        ->with("success_message", "Modo proyecto desactivado correctamente.");
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la configuración',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}