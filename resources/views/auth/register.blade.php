<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Registro - Infantil') }}</title>
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
                            <h5 class="text-center fw-semibold mb-4">Criar nova conta</h5>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="text"
                                           class="form-control form-login @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           placeholder="Nome"
                                           autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="email"
                                           class="form-control form-login @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           placeholder="E-mail">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="password"
                                           class="form-control form-login @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           required
                                           placeholder="Senha (mínimo de 8 caracteres)">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <input type="password"
                                           class="form-control form-login"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           required
                                           placeholder="Confirmar senha">
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-secondary text-white">
                                        {{ __('Registrar') }}
                                    </button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="text-decoration-none small">
                                        {{ __('Já tem uma conta? Faça login') }}
                                    </a>
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
