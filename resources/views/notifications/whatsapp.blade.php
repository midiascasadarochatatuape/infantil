<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Teste Whatsapp ') }}</h2>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong>  {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                @endif
            </div>

            <div class="col-md-5 col-12">
                <form action="/send-whatsapp" method="POST">
                    @csrf
                    <input type="text" name="phone" id="phone" class="form-control mb-3" placeholder="Digite o número (com +55)">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
