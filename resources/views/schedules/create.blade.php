<x-app-layout>
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <h2 class="h4 mb-0">{{ __('Criar escala') }}</h2>
                </div>
            </div>
            <div class="col-md-7 col-12">
                <div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('schedules.store') }}" id="scheduleForm">
                            @csrf

                            <div class="mb-5">
                                <label for="schedule_date" class="form-label h5 fw-bold">{{ __('Data') }}</label>
                                <input type="date"
                                       class="form-control w-50 @error('schedule_date') is-invalid @enderror"
                                       id="schedule_date"
                                       name="schedule_date"
                                       required>
                                @error('schedule_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="assignments" class="mb-3 row">
                                @foreach($positions as $key => $position)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label h5 fw-bold">{{ $position }}</label>
                                        <select name="assignments[{{ $key }}]" class="form-select @error('assignments.'.$key) is-invalid @enderror">
                                            <option value="">Selecione</option>
                                        </select>
                                        @error('assignments.'.$key)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>


                            <div class="d-flex justify-content-between gap-4 mt-4 flex-lg-row flex-md-row-reverse flex-row-reverse">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Criar escala') }}
                                </button>
                                <a href="{{ route('schedules.index') }}" class="btn btn-danger">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        let availableUsers = []; // Store users globally



        document.getElementById('schedule_date').addEventListener('change', function() {
            const date = this.value;
            if (!date) return;

            fetch('/available-users?date=' + date)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(users => {
                    availableUsers = users; // Store users in global variable
                    updateSelects();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erro ao carregar usuários disponíveis');
                });

        });



        document.querySelectorAll('#assignments select').forEach(select => {
            select.addEventListener('change', function() {
                updateSelects();
            });
        });

        function updateSelects() {
            const selects = document.querySelectorAll('#assignments select');
            const selectedValues = Array.from(selects).map(select => select.value).filter(value => value !== '');

            selects.forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="">Selecione</option>';

                availableUsers.forEach(user => {
                    const option = new Option(user.name, user.id);
                    option.disabled = selectedValues.includes(user.id.toString()) && currentValue !== user.id.toString();
                    select.add(option);
                });

                if (currentValue) {
                    select.value = currentValue;
                }
            });

            console.log('dsada' + selectedValues);
        }
    </script>

</x-app-layout>
