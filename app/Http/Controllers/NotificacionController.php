<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Residente;
use App\Traits\BitacoraTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $query = Notificacion::with('residente')->latest('fecha_hora');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('titulo', 'like', "%$s%")->orWhere('contenido', 'like', "%$s%"));
        }
        if ($request->filled('tipo'))  $query->where('tipo', $request->tipo);
        if ($request->filled('leida')) $query->where('leida', (bool) $request->leida);

        $notificaciones = $query->paginate(20);
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function create()
    {
        $residentes = Residente::orderBy('apellido')->get();
        return view('notificaciones.create', compact('residentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'contenido'    => 'required|string',
            'tipo'         => 'required|in:Urgente,Informativa,Recordatorio',
            'destinatario' => 'required|in:todos,individual',
            'residente_id' => 'required_if:destinatario,individual|nullable|exists:residentes,id',
        ]);

        $base = [
            'titulo'      => $request->titulo,
            'contenido'   => $request->contenido,
            'tipo'        => $request->tipo,
            'fecha_hora'  => now(),
            'enviada_por' => Auth::id(),
        ];

        if ($request->destinatario === 'individual') {
            Notificacion::create(array_merge($base, ['residente_id' => $request->residente_id]));
            $msg = 'Notificación enviada al residente seleccionado.';
            $this->registrarEnBitacora('Envió notificación individual');
        } else {
            $ids = Residente::pluck('id');
            foreach ($ids as $rid) {
                Notificacion::create(array_merge($base, ['residente_id' => $rid]));
            }
            $msg = "Notificación enviada a todos los residentes ({$ids->count()}).";
            $this->registrarEnBitacora("Envió notificación masiva a {$ids->count()} residentes");
        }

        return redirect()->route('notificaciones.index')->with('success', $msg);
    }

    public function show(Notificacion $notificacion)
    {
        return view('notificaciones.show', compact('notificacion'));
    }

    public function marcarLeida(Notificacion $notificacion)
    {
        $notificacion->update(['leida' => true]);
        return redirect()->back()->with('success', 'Notificación marcada como leída.');
    }

    public function destroy(Notificacion $notificacion)
    {
        $titulo = $notificacion->titulo;
        $notificacion->delete();
        $this->registrarEnBitacora("Eliminó notificación: $titulo");
        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada.');
    }
}
