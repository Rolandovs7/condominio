<?php

namespace App\Traits;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * BitacoraTrait — v2.0
 * Registra acciones del usuario en la tabla bitacoras.
 * Captura: user_id, nombre, email, acción, fecha, IP y referencia de operación.
 */
trait BitacoraTrait
{
    /**
     * Registra una entrada en la bitácora del sistema.
     *
     * @param  string      $accion       Descripción de la acción realizada.
     * @param  int|null    $id_operacion ID del registro afectado (opcional).
     * @param  string|null $descripcion  Detalle adicional (opcional).
     */
    public function registrarEnBitacora(string $accion, int $id_operacion = null, string $descripcion = null): void
    {
        try {
            $user   = Auth::user();
            $nombre = $user ? $user->name : 'Sistema';

            Bitacora::create([
                'user_id'      => Auth::id(),
                'usuario'      => $nombre,
                'accion'       => $accion,
                'fecha_hora'   => now(),
                'ip'           => request()->ip(),
                'id_operacion' => $id_operacion,
                'descripcion'  => $descripcion,
            ]);
        } catch (\Throwable $e) {
            // No interrumpir el flujo si falla el registro
            Log::warning("BitacoraTrait: no se pudo registrar acción '{$accion}': " . $e->getMessage());
        }
    }
}
