<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Minhas escalas') }}</h2>
                    @if($canManageSchedules)
                        <a href="{{ route('schedules.create') }}" class="btn btn-sm btn-primary rounded-pill">
                            Criar nova escala
                        </a>
                    @endif
                </div>

                @if($groupedSchedules->isEmpty())
                    <div class="alert alert-info">
                        {{ __('Você não tem nenhuma escala programada') }}
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($groupedSchedules as $date => $dateSchedules)

                        <?php
                            $inicio = Carbon\Carbon::parse($date, 'America/Sao_Paulo')->setTime(8, 30)->setTimezone('UTC');
                            $fim = Carbon\Carbon::parse($date, 'America/Sao_Paulo')->setTime(12, 30)->setTimezone('UTC');

                            // Converte para UTC e formata para o padrão do Google Calendar
                            $start = $inicio->setTimezone('UTC')->format('Ymd\THis\Z');
                            $end = $fim->setTimezone('UTC')->format('Ymd\THis\Z');

                            $title = 'Escala da Infantil - ' . \Carbon\Carbon::parse($date)->format('d/m/Y');
                            $details = 'Serviço à comunidade Casa da Rocha Tatuapé';
                            $location = 'Rua Platina, 213';

                            $url = 'https://www.google.com/calendar/render?action=TEMPLATE' .
                                '&text=' . urlencode($title) .
                                '&dates=' . $start . '/' . $end .
                                '&details=' . urlencode($details) .
                                '&location=' . urlencode($location) .
                                '&sf=true&output=ics';



                            $titles = 'Escala da Infantil - ' . \Carbon\Carbon::parse($date)->format('d/m/Y');
                            $descriptions = 'Serviço à comunidade Casa da Rocha Tatuapé';
                            $locations = 'A Casa da Rocha Tatuapé, Rua Platina, 213';

                            // Pegue as datas da variável $schedule
                            $starts = Carbon\Carbon::parse($date, 'America/Sao_Paulo')->setTime(8, 30)->setTimezone('UTC');
                            $ends = $starts->copy()->addHours(3);

                            $startFormatteds = $starts->format('Ymd\THis\Z');
                            $endFormatteds = $ends->format('Ymd\THis\Z');

                            $alarmTrigger = "-P1D";

                            $icsContent = <<<ICS
                        BEGIN:VCALENDAR
                        VERSION:2.0
                        CALSCALE:GREGORIAN
                        BEGIN:VEVENT
                        SUMMARY:$titles
                        DESCRIPTION:$descriptions
                        LOCATION:$locations
                        DTSTART:$startFormatteds
                        DTEND:$endFormatteds
                        STATUS:CONFIRMED
                        BEGIN:VALARM
                        TRIGGER:$alarmTrigger
                        ACTION:DISPLAY
                        DESCRIPTION:Lembrete do evento: $titles
                        END:VALARM
                        END:VEVENT
                        END:VCALENDAR
                        ICS;

                            $encodedIcs = rawurlencode($icsContent);
                            ?>

                        <div class="col-md-3 col-12">
                            <div class="accordion d-md-none d-block" id="accordionDashboard">
                                <div class="accordion-item">
                                    <h2 class="accordion-header d-flex flex-row-reverse align-items-center">
                                        <button class="accordion-button h4 m-0 fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}" aria-expanded="true" aria-controls="{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}">
                                            {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                        </button>
                                        @if($canManageSchedules)
                                            <a href="{{ route('schedules.edit-date', ['date' => \Carbon\Carbon::parse($date)->format('Y-m-d')]) }}" class="">
                                                <span class="material-symbols-outlined symbol-filled text-primary mx-2 mt-1">app_registration</span>
                                            </a>
                                        @endif
                                    </h2>
                                    <div id="{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}" class="accordion-collapse collapse" data-bs-parent="#accordionDashboard">
                                        <div class="accordion-body">
                                            @foreach($dateSchedules as $schedule)
                                            <div class="d-flex">
                                                <div class="d-flex flex-grow-1 flex-column">
                                                    <h5 class="m-0 text-secondary">{{ $positions[$schedule->position] }}</h5>
                                                    <p class="m-0 {{ ($user->name == $schedule->user->name) ? 'fw-bold' : ''}}">{{ $schedule->user->name }}</p>
                                                </div>
                                                @if($canManageSchedules)
                                                <div class="d-flex flex-column gap-0 justify-content-center">
                                                    <a href="{{ route('schedules.edit', $schedule) }}" class="">
                                                        <span class="material-symbols-outlined text-secondary" style="font-size: 1.2rem">edit</span>
                                                    </a>
                                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-0 border-0 text-center bg-white" style="font-size:.65rem;" onclick="return confirm('Tem certeza que deseja excluir?')">
                                                            <span class="material-symbols-outlined text-danger" style="font-size: 1.2rem">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                            </div>
                                            <hr class="border-1 border-dark mt-2">
                                            @endforeach
                                            <div class="d-flex flex-column gap-2 justify-content-center">
                                                <a href="{{ $url }}" target="_blank" class="btn btn-primary">Adicionar ao Google Calendar</a>
                                                <a href="data:text/calendar;charset=utf8,{{ $encodedIcs }}" download="evento.ics" class="btn btn-primary">Adicionar ao Calendário .ics</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="rounded-4 lista-escala bg-white d-flex flex-column d-md-block d-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="h4 mb-0 fw-semibold">
                                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                    </h3>
                                    @if($canManageSchedules)
                                        <a href="{{ route('schedules.edit-date', ['date' => \Carbon\Carbon::parse($date)->format('Y-m-d')]) }}" class="">
                                            <span class="material-symbols-outlined symbol-filled text-primary">app_registration</span>
                                        </a>
                                    @endif
                                </div>
                                <hr class="border-1 border-secondary">

                                @foreach($dateSchedules as $schedule)
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h5 class="m-0 text-secondary">{{ $positions[$schedule->position] }}</h5>
                                            <p class="m-0 {{ ($user->name == $schedule->user->name) ? 'fw-bold' : ''}}">{{ $schedule->user->name }}</p>
                                        </div>
                                        @if($canManageSchedules)
                                            <div class="d-flex flex-column gap-0 justify-content-center">
                                                <a href="{{ route('schedules.edit', $schedule) }}" class="">
                                                    <span class="material-symbols-outlined text-secondary" style="font-size: 1.2rem">edit</span>
                                                </a>
                                                <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-0 border-0 text-center" style="font-size:.65rem;" onclick="return confirm('Tem certeza que deseja excluir?')">
                                                        <span class="material-symbols-outlined text-danger" style="font-size: 1.2rem">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    <hr class="border-1 border-dark my-2">
                                @endforeach

                                @if($dateSchedules->first()->notes)
                                    <div class="alert alert-secondary mt-4">
                                        <strong>Notes:</strong> {{ $dateSchedules->first()->notes }}
                                    </div>
                                @endif
                                <div class="d-flex flex-column gap-2 justify-content-center">
                                    <a href="{{ $url }}" target="_blank" class="btn btn-primary">Adicionar ao Google Calendar</a>
                                    <a href="data:text/calendar;charset=utf8,{{ $encodedIcs }}" download="evento.ics" class="btn btn-primary">Adicionar ao Calendário .ics</a>

                                </div>
                            </div>
                        </div>

                    @endforeach
                    </div>

                </div>
                    {{-- <div class="mt-4">
                        {{ $schedules->links() }}
                    </div> --}}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
