<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('build/assets/img/logo-horizontal-branco.svg') }}" width="130" alt="" />
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item d-md-none d-block py-2 my-2 border-bottom border-1 border-secondary"></li>
                <li class="nav-item order-lg-0 order-md-0 order-1">
                    <a class="nav-link mx-2 link-light {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        {{ __('Todas as escalas') }}
                    </a>
                </li>

                <li class="nav-item order-lg-1 order-md-1 order-2">
                    <a class="nav-link mx-2 link-light {{ request()->routeIs('schedules.*') ? 'active' : '' }}"
                       href="{{ route('schedules.index') }}">
                        {{ __('Minhas escalas') }}
                    </a>
                </li>

                <li class="nav-item order-lg-2 order-md-2 order-3">
                    <a class="nav-link mx-2 link-light {{ request()->routeIs('blocked-dates.*') ? 'active' : '' }}"
                       href="{{ route('blocked-dates.index') }}">
                        {{ __('Bloquear datas') }}
                    </a>
                </li>

                @if(auth()->user()->isAdmin())
                    <li class="nav-item order-lg-3 order-md-3 order-4">
                        <a class="nav-link mx-2 link-light {{ request()->routeIs('users.*') ? 'active' : '' }}"
                           href="{{ route('users.index') }}">
                            {{ __('Usuários') }}
                        </a>
                    </li>
                @endif

                <li class="nav-item order-lg-4 order-md-4 order-5 me-lg-5">
                    <a class="nav-link mx-2 link-light {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                       href="{{ route('profile.edit') }}">
                        {{ __('Meus dados') }}
                    </a>
                </li>

                <li class="nav-item d-flex align-items-center ms-lg-5 ms-md-2 ms-2 order-lg-5 order-md-5 order-0">
                    <p class="m-0 text-white">Olá, {{auth()->user()->name}}</p>
                    <div class="divider mx-2 text-white">|</div>
                    <a class="nav-link link-light px-0" href="{{ route('logout') }}">
                        {{ __('Sair') }}
                    </a>
                </li>
            </ul>

            <!-- Notification Icon -->
            @if(auth()->user()->isAdmin())
            <div class="d-flex align-items-center">
                <div class="position-relative">
                    <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')">
                        <span class="material-symbols-outlined symbol-filled text-white">
                            notifications
                            </span>
                        @if($unreadNotifications = \App\Models\DateModification::where('read', false)->count())
                            <span class="icon-notification badge rounded-pill bg-danger">
                                {{ $unreadNotifications }}
                            </span>
                        @endif
                    </x-nav-link>
                </div>
            </div>
            @endif
        </div>
    </div>
</nav>
