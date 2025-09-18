<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">Adicionar usuário</h2>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Nome') }}</label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('E-mail') }}</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 d-none">
                                <label for="telephone" class="form-label">{{ __('Telefone') }}</label>
                                <input type="tel"
                                       class="form-control @error('telephone') is-invalid @enderror"
                                       id="telephone"
                                       name="telephone"
                                       value="{{ old('telephone') }}"
                                       maxlength="15"
                                       required>
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Senha') }}</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">{{ __('Tipo') }}</label>
                                <select name="role"
                                        id="role"
                                        class="form-select @error('role') is-invalid @enderror"
                                        required>
                                    <option value="member">Voluntário</option>
                                    <option value="admin">Administrador</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between gap-4 mt-4 flex-lg-row flex-md-row-reverse flex-row-reverse">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Criar usuário') }}
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-danger">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
