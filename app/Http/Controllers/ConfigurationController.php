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

            // Lista de configuraciones válidas
            $validKeys = ['maintenance', 'project_mode', 'question_mode'];

            // Verificar si la clave es válida
            if (!in_array($request->key, $validKeys)) {
                return redirect()->route('admin.profile')
                    ->with("error_title", "Configuración inválida")
                    ->with("error_message", "La clave proporcionada no es válida.");
            }

            // Buscar configuración por clave
            $config = Setting::where('key', $request->key)->first();

            if (!$config) {
                return redirect()->route('admin.profile')
                    ->with("error_title", "Configuración no encontrada")
                    ->with("error_message", "No se encontró la configuración especificada.");
            }

            // Alternar el valor
            $config->update([
                'value' => $config->value == 0 ? 1 : 0,
            ]);

            DB::commit();

            // Mensajes dinámicos
            $status = $config->value == 1 ? 'activado' : 'desactivado';
            $modeName = ucwords(str_replace('_', ' ', $request->key));

            return redirect()->route('admin.profile')
                ->with("success_title", "Configuración actualizada")
                ->with("success_message", "Modo {$modeName} {$status} correctamente.");
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error al actualizar la configuración',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}