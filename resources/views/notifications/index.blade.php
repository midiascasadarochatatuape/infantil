<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Notificações') }}</h2>
                </div>
                <div class="row gx-4">
                @foreach($notifications as $notification)
                    <div class="col-md-2 mb-3 d-flex">
                        <div class="px-4 py-2 rounded-4 w-100 neo {{ $notification->read ? 'bg-danger' : 'bg-lighter' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="{{ $notification->read ? 'text-white' : '' }}">{{ $notification->user->name }}</h5>
                                    <p class="small m-0 {{ $notification->read ? 'text-white' : '' }}">
                                        @if($notification->action_type === 'blocked')
                                            Bloqueou
                                        @elseif($notification->action_type === 'multiple_blocks')
                                            Múltiplos usuários bloquearam
                                        @else
                                            Liberou
                                        @endif
                                        a data: {{ \Carbon\Carbon::parse($notification->modified_date)->format('d/m/Y') }}
                                    </p>
                                    <small class="mb-2 d-block {{ $notification->read ? 'text-white' : 'text-muted' }}">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </small>
                                    @if(!$notification->read)
                                    <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Marcar como lido</button>
                                    </form>
                                @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
