<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-jet-nav-link href="{{ route('create_banco_horas') }}" :active="request()->is('/bancodehoras/criar')">
                {{ __('Comunicado de banco de horas') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('warning_compensada') }}" :active="request()->is('comunicados/todos')">
                {{ __('Comunicado de compensada') }}
            </x-jet-nav-link>
            @if(Auth::user()->admin == 1 || Auth::user()->admin == 2)
                <x-jet-nav-link href="{{ route('solicitacoes_banco') }}" :active="request()->is('comunicados/solicitacoes')">
                    {{ __('Solicitações de funcionários') }}
                </x-jet-nav-link>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="col-md-4 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 text-center">
                @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">

                        <strong>{{ $message }}</strong>

                    </div>

                @endif


                @if ($message = Session::get('error'))

                    <div class="alert alert-danger alert-block">

                        <strong>{{ $message }}</strong>

                    </div>

                @endif
                <form class="mb-3">
                    <select class="form-select form-control" id="funcio">
                        <option value="0" selected>Selecione um funcionário</option>
                        @foreach($funcionarios as $funcionario)
                            <option value="{{ $funcionario->matricula }}">{{ $funcionario->nome }} | {{\Carbon\Carbon::createFromFormat('Y-m-d',$funcionario->data_nasc)->format('d/m/Y')}}</option>
                        @endforeach
                    </select>
                </form>
                <table class="table table-responsive table-hover text-center mb-3">
                    <thead class="thead-dark">
                    <tr>
                        <th id="show"><span id="horas">0</span> Horas e <span id="min">0</span> Minutos</th>
                    </tr>
                    </thead>
                </table>
                    <a href="#" class="btn btn-info" id="visualiza">Visualizar solicitações</a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
<script>
    $('#funcio').on('change',function( ){
        var id = $(this).val();
        if(id !== "0")
        {
            var vis = '{{route('banco_dash',":id")}}';
            vis = vis.replace(':id',id);
            $('#visualiza').attr("href",vis);
            var url = '{{ route('show_horas',":id") }}';
            var token = '{{ csrf_token() }}';
            url = url.replace(':id',id);
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {'_token' : token},
                beforeSend: function () {
                    $('#show').html('<i class="fa fa-spinner fa-spin fa-lg" id="loading">');
                    $('#visualiza').html('<i class="fa fa-spinner fa-spin fa-lg" id="loading">');
                },
                success: function(data) {
                    if(data.response === 200)
                    {
                        let horas = data.total_horas.split(':');
                        $('#show').html(`<span>`+ horas[0] +`</span> Horas e <span>`+ horas[1] +`</span> Minutos`);
                        $('#visualiza').text('Visualizar solicitações');
                    }
                    else
                        alert(data.mensagem);
                },
                error: function() {
                    alert('Ocorreu um erro no sistema!');
                }
            });
        }else{
            $('#show').html(`<span id="horas">0</span> Horas e <span id="min">0</span> Minutos`);
            $('#visualiza').attr("href","#");
        }
    });
</script>
