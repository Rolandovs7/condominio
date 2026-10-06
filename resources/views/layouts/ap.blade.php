<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de Gestión de Condominio San Diego" />
        <meta name="author" content="Grupo 3" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Condominio San Diego — @yield('title', 'Panel')</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('css/plantilla.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('css')
    </head>
    <body class="sb-nav-fixed">
        <x-navigation-header />
        <div id="layoutSidenav">
            <x-navigation-menu />
            <div id="layoutSidenav_content">
                <main>
                    {{-- Alertas globales --}}
                    @include('layouts.partials.alert')
                    @yield('content')
                </main>
                <x-footer />
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        @stack('js')

        {{-- Registro de cierre de página --}}
        <script>
        window.addEventListener('beforeunload', () => {
            navigator.sendBeacon('{{ route("bitacora.page-close") }}',
                new URLSearchParams({ _token: '{{ csrf_token() }}' }));
        });
        </script>
    </body>
</html>
