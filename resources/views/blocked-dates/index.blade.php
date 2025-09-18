<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Datas Bloqueadas') }}</h2>
                </div>
            </div>
            <div class="col-12 d-flex flex-column">
                <!-- Formulário de bloqueio -->
                <div class="col-md-7">
                    <div class="card-body">
                        <form method="POST" action="{{ route('blocked-dates.store') }}" class="mb-4">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-5 col-md-6 col-12 mb-lg-0 mb-md-0 mb-0">
                                    <label for="blocked_date" class="form-label h5 fw-bold">{{ __('Data') }}</label>
                                    <input type="date"
                                           class="form-control m-0 @error('blocked_date') is-invalid @enderror"
                                           id="blocked_date"
                                           name="blocked_date"
                                           required>
                                    @error('blocked_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-5 col-12">
                                    <button type="submit" class="btn btn-primary d-flex w-100 justify-content-center" style="">
                                        {{ __('Bloquear Data') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if($blockedDates->isEmpty())
                            <div class="alert alert-info">
                                {{ __('Nenhuma data bloqueada encontrada.') }}
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Lista de datas bloqueadas -->
                <div class="mt-4">
                    <h3 class="h5 mb-3">{{ auth()->user()->isAdmin() ? 'Todas as Datas Bloqueadas' : 'Minhas Datas Bloqueadas' }}</h3>
                    <div class="d-flex gap-3 flex-wrap flex-row">
                    @foreach($blockedDates as $blockedDate)
                        <div class="d-flex block-list">
                            <div class="card-body d-flex">
                                <div class="d-flex flex-fill gap-2 py-2 flex-column bg-white shadow rounded-3 justify-content-between align-items-start">
                                    <div class="p-2 w-100 d-flex flex-column justify-content-center align-items-center">
                                        <p class="mb-1 fw-bold text-center">{{ $blockedDate->blocked_date->format('d/m/Y') }}</p>
                                        @if(auth()->user()->isAdmin())
                                            <p class="mb-0 small text-uppercase"><strong>{{ $blockedDate->user->name }}</strong></p>
                                        @endif

                                        @if($blockedDate->reason)
                                            <p class="mb-0"><strong>Motivo:</strong> {{ $blockedDate->reason }}</p>
                                        @endif
                                    </div>
                                    <form action="{{ route('blocked-dates.destroy', $blockedDate) }}" method="POST" class="d-flex justify-content-center w-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-3 btn-sm" onclick="return confirm('Tem certeza que deseja remover este bloqueio?')">
                                            Remover
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
