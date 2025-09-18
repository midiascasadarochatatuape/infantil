<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Editar os dados de ') }}{{ old('name', $user->name) }}</h2>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong>  {{ session()->get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <div class="col-md-5 col-12">
                <div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label h5 fw-bold">{{ __('Nome') }}</label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label h5 fw-bold">{{ __('E-mail') }}</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-none">
                                <label for="email" class="form-label h5 fw-bold">{{ __('Telefone') }}</label>
                                <input type="tel"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="telephone"
                                       name="telephone"
                                       value="{{ old('telephone', $user->telephone) }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label h5 fw-bold">{{ __('Senha') }}</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       autocomplete="new-password"
                                       name="password">
                                <div class="form-text">Deixe em branco para manter a senha atual</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label h5 fw-bold">{{ __('Tipo') }}</label>
                                <select name="role"
                                        id="role"
                                        class="form-select @error('role') is-invalid @enderror"
                                        required>
                                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Voluntário</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between gap-4 mt-4 flex-lg-row flex-md-row-reverse flex-row-reverse">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar Usuário') }}
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
