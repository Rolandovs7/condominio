<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\BitacoraTrait;

class HomeController extends Controller
{
    use BitacoraTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Panel de control principal.
     */
    public function index()
    {
        $this->registrarEnBitacora('Accedió al panel de control');
        return view('panel.index');
    }
}
