<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Login - Infantil') }}</title>
    <link href="{{ asset('build/assets/css/styles.css')}}" rel="stylesheet">
</head>
<body class="bg-login">
    <div class="login-page d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="login-box form-signin">
                        <div class="d-flex align-items-center justify-content-center py-4">
                            <img src="{{ asset('build/assets/img/logo-horizontal.svg') }}" width="170" alt="">
                        </div>

                        <div class="p-3">
                            @if (session('status'))
                                <div class="alert alert-success mb-4">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <h5 class="text-center fw-semibold mb-4">Escala Infantil</h5>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-0">
                                    <input type="email"
                                           class="form-control form-login @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           placeholder="E-mail"
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="password"
                                           class="form-control form-login @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Senha"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-secondary text-white">
                                        {{ __('Logar') }}
                                    </button>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">


                                    <a href="{{ route('register') }}" class="text-decoration-none">
                                        {{ __('Criar nova conta') }}
                                    </a>
                                </div>

                                <div class="ps-0 form-check">
                                     @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                            {{ __('Esqueci minha senha') }}
                                        </a>
                                    @endif
                                    {{-- <input type="checkbox"
                                           class="form-check-input"
                                           id="remember_me"
                                           name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        {{ __('Lembre-me') }}
                                    </label> --}}
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('build/assets/css/styles.css')}}"></script>
</body>
</html>
