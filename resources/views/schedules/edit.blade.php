<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">{{ __('Editar escala') }}</h2>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('schedules.update', $schedule) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label h5 m-0 fw-bold">{{ __('Data') }}</label>
                                <div class="form-control-plaintext">
                                    {{ $schedule->schedule_date->format('d/m/Y') }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label h5 m-0 fw-bold">{{ __('Posição') }}</label>
                                <div class="form-control-plaintext">
                                    {{ $positions[$schedule->position] }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="user_id" class="form-label h5 fw-bold">{{ __('Membro') }}</label>
                                <select name="user_id" id="user_id"
                                        class="form-select @error('user_id') is-invalid @enderror">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                                {{ $schedule->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label h5 fw-bold">{{ __('Anotações') }}</label>
                                <textarea id="notes"
                                          name="notes"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          rows="3">{{ $schedule->notes }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between gap-4 mt-4 flex-lg-row flex-md-row-reverse flex-row-reverse">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar escala') }}
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-danger">
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
