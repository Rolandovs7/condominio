<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'email',
        'telefono',
        'tipo_residente',
    ];

    // ── Relaciones ────────────────────────────────────────────────────────────

    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }

    public function multas()
    {
        return $this->hasMany(Multa::class);
    }

    public function unidades()
    {
        return $this->hasMany(Unidad::class);
    }

    public function reclamos()
    {
        return $this->hasMany(Reclamo::class);
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Nombre completo del residente (Nombre Apellido).
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->apellido}");
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Indica si el residente tiene al menos una cuota vencida y no pagada.
     * Utilizado para restringir reservas de áreas comunes mientras exista
     * morosidad (CU-Reserva-002).
     */
    public function tieneMorosidad(): bool
    {
        return $this->cuotas()
            ->where('estado', '!=', 'pagado')
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->exists();
    }

    /**
     * Total de cuotas pendientes en bolivianos.
     */
    public function totalAdeudado(): float
    {
        return (float) $this->cuotas()
            ->where('estado', '!=', 'pagado')
            ->sum('monto');
    }
}
