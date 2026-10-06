<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración de mejora de rendimiento — v2.0
 * Agrega índices a columnas frecuentemente usadas en búsquedas y filtros.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Pagos: búsqueda por fecha, método y estado
        Schema::table('pagos', function (Blueprint $table) {
            if (!$this->hasIndex('pagos', 'pagos_fecha_pago_index')) {
                $table->index('fecha_pago');
            }
            if (!$this->hasIndex('pagos', 'pagos_metodo_index')) {
                $table->index('metodo');
            }
            if (!$this->hasIndex('pagos', 'pagos_estado_index')) {
                $table->index('estado');
            }
        });

        // Cuotas: filtro por estado y residente
        Schema::table('cuotas', function (Blueprint $table) {
            if (!$this->hasIndex('cuotas', 'cuotas_estado_index')) {
                $table->index('estado');
            }
        });

        // Notificaciones: filtro por leida
        Schema::table('notificaciones', function (Blueprint $table) {
            if (!$this->hasIndex('notificaciones', 'notificaciones_leida_index')) {
                $table->index('leida');
            }
        });

        // Bitácora: filtro por fecha_hora y usuario
        Schema::table('bitacoras', function (Blueprint $table) {
            if (!$this->hasIndex('bitacoras', 'bitacoras_fecha_hora_index')) {
                $table->index('fecha_hora');
            }
        });

        // Visitas: filtro por estado y fecha
        Schema::table('visitas', function (Blueprint $table) {
            if (!$this->hasIndex('visitas', 'visitas_estado_index')) {
                $table->index('estado');
            }
        });

        // Incidencias: filtro por estado y prioridad
        Schema::table('incidencias', function (Blueprint $table) {
            if (!$this->hasIndex('incidencias', 'incidencias_estado_index')) {
                $table->index('estado');
            }
            if (Schema::hasColumn('incidencias', 'prioridad') && !$this->hasIndex('incidencias', 'incidencias_prioridad_index')) {
                $table->index('prioridad');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropIndexIfExists('pagos_fecha_pago_index');
            $table->dropIndexIfExists('pagos_metodo_index');
            $table->dropIndexIfExists('pagos_estado_index');
        });
        Schema::table('cuotas',        fn($t) => $t->dropIndexIfExists('cuotas_estado_index'));
        Schema::table('notificaciones', fn($t) => $t->dropIndexIfExists('notificaciones_leida_index'));
        Schema::table('bitacoras',      fn($t) => $t->dropIndexIfExists('bitacoras_fecha_hora_index'));
        Schema::table('visitas',        fn($t) => $t->dropIndexIfExists('visitas_estado_index'));
        Schema::table('incidencias',    function ($t) {
            $t->dropIndexIfExists('incidencias_estado_index');
            $t->dropIndexIfExists('incidencias_prioridad_index');
        });
    }

    private function hasIndex(string $table, string $index): bool
    {
        try {
            $indexes = \DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$index]);
            return !empty($indexes);
        } catch (\Exception $e) {
            return false;
        }
    }
};
