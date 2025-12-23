<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap Multiselect CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.0/dist/css/bootstrap-multiselect.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('styles')

    {{-- LIVEWIRE STYLES --}}
    @livewireStyles
</head>

<body>
    <div id="app">

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('information.*') ? 'active fw-bold' : '' }}"
                                    href="{{ route('information.index') }}">
                                    <i class="bi bi-info-circle me-1"></i> Information
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('leads.*') ? 'active fw-bold' : '' }}"
                                    href="{{ route('leads.index') }}">
                                    <i class="bi bi-people me-1"></i> Leads
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- NOTIFICATION --}}
        <div id="notify-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999" wire:ignore></div>

        {{-- MAIN CONTENT --}}
        <main class="py-4 container">

            {{-- FOR LIVEWIRE ROUTE COMPONENTS --}}
            {{ $slot ?? '' }}

            {{-- FOR NORMAL BLADE VIEWS --}}
            @yield('content')

        </main>
    </div>

    {{-- LIVEWIRE SCRIPTS --}}
    @livewireScripts

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- EXTRA SCRIPTS --}}
    @stack('scripts')

    <script>
        var userId = $('meta[name="user-id"]').attr('content');

        if (userId !== '8') {
            $(document).bind("contextmenu", function(e) {
                return false;
            });
            $(document).on("cut", function(e) {
                alert('cut. not allowed!');
                e.preventDefault();
            });
            $(document).on("copy", function(e) {
                alert('copy. not allowed!');
                e.preventDefault();
            });
            $(document).keydown(function(e) {
                // console.log(e.which)
                if (e.which === 123) {
                    alert('not allowed!');
                    e.preventDefault();
                    return false
                }

            });
        }
        $(document).ready(function() {
            //$('#example').DataTable();
            // var table = $('#example').DataTable({
            //     "order": [[5, 'desc']]
            //     });
        });

        window.addEventListener('notify', event => {
        const { type, message } = event.detail;

        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `${message} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;

        const container = document.getElementById('notify-container');
        container.appendChild(alert);

        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 500);
        }, 8000);
    });

    </script>
</body>

</html>
