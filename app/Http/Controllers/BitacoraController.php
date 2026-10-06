<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $bitacoras = Bitacora::with('user')
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                $q->where(function ($sq) use ($s) {
                    $sq->where('usuario', 'like', "%$s%")
                       ->orWhere('accion', 'like', "%$s%")
                       ->orWhere('ip', 'like', "%$s%");
                });
            })
            ->when($request->filled('desde'), fn($q) => $q->whereDate('fecha_hora', '>=', $request->desde))
            ->when($request->filled('hasta'), fn($q) => $q->whereDate('fecha_hora', '<=', $request->hasta))
            ->latest('fecha_hora')
            ->paginate(25);

        return view('bitacora.index', compact('bitacoras'));
    }

    public function show($id)
    {
        $bitacora = Bitacora::with('user')->findOrFail($id);
        return view('bitacora.show', compact('bitacora'));
    }

    public function destroy($id)
    {
        Bitacora::findOrFail($id)->delete();
        return redirect()->route('bitacora.index')->with('success', 'Registro eliminado.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'accion' => 'required|string|max:255',
        ]);

        Bitacora::create([
            'accion'     => $request->accion,
            'ip'         => $request->ip(),
            'fecha_hora' => now(),
        ]);

        return redirect()->route('bitacora.index')->with('success', 'Bitácora registrada.');
    }
}
