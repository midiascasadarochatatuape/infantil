<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Usuários') }}</h2>
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        Adicionar novo usuário
                    </a>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white w-75">Nome</th>
                                <th class="bg-primary text-white">E-mail</th>
                                {{-- <th class="bg-primary text-white">Tipo</th> --}}
                                <th class="bg-primary text-white text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-1 align-middle">{{ $user->name }}</td>
                                    <td class="py-1 align-middle">{{ $user->email }}</td>
                                    {{-- <td class="py-1 align-middle">{{ ucfirst($user->role) }}</td> --}}
                                    <td class="py-1 align-middle">
                                        <div class="d-flex gap-2 justify-content-end align-items-center">
                                            <a href="{{ route('users.edit', $user) }}">
                                                <span class="material-symbols-outlined text-secondary" style="font-size: 1.2rem">edit</span>
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-0 border-0 bg-transparent" onclick="return confirm('Tem certeza?')">
                                                    <span class="material-symbols-outlined text-danger" style="font-size: 1.2rem">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="mt-4">
                    {{ $users->links('components.pagination') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
