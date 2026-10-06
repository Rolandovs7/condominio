<?php

namespace App\Http\Controllers;

use App\Models\Residente;
use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class ResidenteController extends Controller
{
    use BitacoraTrait;

    public function index(Request $request)
    {
        $residentes = Residente::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                $q->where(function ($sq) use ($s) {
                    $sq->where('nombre', 'like', "%$s%")
                       ->orWhere('apellido', 'like', "%$s%")
                       ->orWhere('ci', 'like', "%$s%")
                       ->orWhere('email', 'like', "%$s%");
                });
            })
            ->when($request->filled('tipo_residente'), fn($q) =>
                $q->where('tipo_residente', $request->tipo_residente)
            )
            ->orderBy('apellido')
            ->paginate(15);

        return view('residentes.index', compact('residentes'));
    }

    public function create()
    {
        return view('residentes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:255',
            'apellido'        => 'required|string|max:255',
            'ci'              => 'required|string|max:20|unique:residentes',
            'email'           => 'required|email|max:255|unique:residentes',
            'tipo_residente'  => 'required|in:propietario,inquilino',
        ]);

        $residente = Residente::create($validated);
        $this->registrarEnBitacora('Residente creado', $residente->id);

        return redirect()->route('residentes.index')
            ->with('success', "Residente {$residente->nombre_completo} registrado correctamente.");
    }

    public function show(Residente $residente)
    {
        $residente->load(['cuotas.pagos', 'multas', 'unidades']);
        return view('residentes.show', compact('residente'));
    }

    public function edit(Residente $residente)
    {
        return view('residentes.edit', compact('residente'));
    }

    public function update(Request $request, Residente $residente)
    {
        $validated = $request->validate([
            'nombre'         => 'required|string|max:255',
            'apellido'       => 'required|string|max:255',
            'ci'             => "required|string|max:20|unique:residentes,ci,{$residente->id}",
            'email'          => "required|email|max:255|unique:residentes,email,{$residente->id}",
            'tipo_residente' => 'required|in:propietario,inquilino',
        ]);

        $residente->update($validated);
        $this->registrarEnBitacora('Residente actualizado', $residente->id);

        return redirect()->route('residentes.index')
            ->with('success', "Residente {$residente->nombre_completo} actualizado correctamente.");
    }

    public function destroy(Residente $residente)
    {
        $nombre = $residente->nombre_completo;
        $residente->delete();
        $this->registrarEnBitacora('Residente eliminado');

        return redirect()->route('residentes.index')
            ->with('success', "Residente $nombre eliminado correctamente.");
    }
}
