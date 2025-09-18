<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">Editar escala do <br class="d-md-none d-block" />dia {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h2>
                    <form action="{{ route('schedules.destroy-date', $date) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm rounded-pill px-3 btn-danger" onclick="return confirm('Tem certeza que deseja excluir toda a escala desta data?')">
                            Excluir escala
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-md-7 col-12">
                <div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('schedules.update-date', $date) }}" id="scheduleForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="schedule_date" value="{{ $date }}">

                            <div id="assignments" class="mb-3 row">
                                @foreach($positions as $key => $position)
                                    <div class="col-md-4 col-6 mb-3">
                                        <label class="form-label h5 fw-bold">{{ $position }}</label>
                                        <select name="assignments[{{ $key }}]"
                                                class="form-select @error('assignments.'.$key) is-invalid @enderror">
                                            <option value="">Selecione</option>
                                            @foreach($availableUsers as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ isset($currentAssignments[$key]) && $currentAssignments[$key]->user_id == $user->id ? 'selected' : '' }}
                                                    {{ in_array($user->id, $assignedUsers) && (!isset($currentAssignments[$key]) || $currentAssignments[$key]->user_id != $user->id) ? 'disabled' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('assignments.'.$key)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
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
