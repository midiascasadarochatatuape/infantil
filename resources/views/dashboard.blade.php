<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Todas as Escalas') }}</h2>
                    @if($canManageSchedules)
                        <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary rounded-pill">
                            Criar nova escala
                        </a>
                    @endif
                </div>

                @if($groupedSchedules->isEmpty())
                    <div class="alert alert-info">
                        {{ __('Nenhuma escala encontrada.') }}
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($groupedSchedules as $date => $dateSchedules)
                            <div class="col-md-3 col-12">

                                <div class="accordion d-md-none d-block" id="accordionDashboard">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header d-flex justify-content-between align-items-center">
                                            @if($canManageSchedules)
                                                <a href="{{ route('schedules.edit-date', ['date' => \Carbon\Carbon::parse($date)->format('Y-m-d')]) }}" class="">
                                                    <span class="material-symbols-outlined symbol-filled text-primary ms-2 mt-1">app_registration</span>
                                                </a>
                                            @endif
                                            <button class="accordion-button h4 m-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}" aria-expanded="true" aria-controls="{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}">
                                                {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                            </button>

                                        </h2>
                                        <div id="{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}" class="accordion-collapse collapse" data-bs-parent="#accordionDashboard">
                                            <div class="accordion-body">
                                                @foreach($dateSchedules as $schedule)
                                                    <div class="d-flex flex-column">
                                                        <h5 class="m-0 text-secondary">{{ $positions[$schedule->position] }}</h5>
                                                        <p class="m-0 {{ ($user->name == $schedule->user->name) ? 'fw-bold' : ''}}">{{ $schedule->user->name }}</p>
                                                    </div>

                                                    <hr class="border-1 border-dark my-2">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="rounded-4 lista-escala bg-white d-md-block d-none">
                                    <div class="d-md-flex justify-content-between align-items-center mb-3">
                                        <h3 class="h4 mb-0 fw-semibold">
                                            {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                        </h3>
                                        @if($canManageSchedules)
                                            <a href="{{ route('schedules.edit-date', ['date' => \Carbon\Carbon::parse($date)->format('Y-m-d')]) }}" class="">
                                                <span class="material-symbols-outlined symbol-filled text-primary mt-1">app_registration</span>
                                            </a>
                                        @endif
                                    </div>

                                    <hr class="border-1 border-secondary">
                                    @foreach($dateSchedules as $schedule)
                                        <div class="d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex flex-column">
                                                    <h5 class="m-0 text-secondary">{{ $positions[$schedule->position] }}</h5>
                                                    <p class="m-0 {{ ($user->name == $schedule->user->name) ? 'fw-bold' : ''}}">{{ $schedule->user->name }}</p>
                                                </div>
                                                @if($canManageSchedules)
                                                    <a href="{{ route('schedules.edit', $schedule) }}" class="">
                                                        <span class="material-symbols-outlined text-secondary" style="font-size: 1.2rem">edit</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <hr class="border-1 border-dark my-2">
                                    @endforeach

                                    @if($dateSchedules->first()->notes)
                                        <div class="alert alert-secondary mt-4">
                                            <strong>Observações:</strong> {{ $dateSchedules->first()->notes }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
