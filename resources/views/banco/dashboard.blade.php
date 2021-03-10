<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-jet-nav-link href="{{ route('create_banco_horas') }}" :active="request()->is('/bancodehoras/criar')">
                {{ __('Comunicado de banco de horas') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('warning_compensada') }}" :active="request()->is('/bancodehoras/aviso')">
                {{ __('Comunicado de compensada') }}
            </x-jet-nav-link>
            @if(Auth::user()->admin == 1 || Auth::user()->admin == 2)
                <x-jet-nav-link href="{{ route('solicitacoes_banco') }}" :active="request()->is('bancodehoras/solicitacoes')">
                    {{ __('Solicitações de funcionários') }}
                </x-jet-nav-link>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 mx-auto">
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
            <div class="alert alert-primary" role="alert">
                @if(!Request::is('admin/*'))
                    Banco do funcionário: {{ $funcionario->nome }}
                @else
                    Solicitações feitas por: {{ $funcionario->nome }}
                @endif
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3" style="overflow: auto">
                <div class="table-responsive">
                    <table class="table mb-3">
                        <thead class="text-center">
                        <tr>
                            <th scope="col">Funcionário</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Data da solicitação</th>
                            <th scope="col">Data Aprovado / Recusado</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @foreach($banco as $solicitacao)
                            <tr>
                                <th class="text-left"><a href="{{ route('show_banco',$solicitacao->id) }}">{{strlen($solicitacao->funcionario->nome) > 40 ? substr($solicitacao->funcionario->nome,0,40)."..." : $solicitacao->funcionario->nome}}</a></th>
                                <td>@if($solicitacao->tipo == 1)
                                        Banco de Horas
                                    @else
                                        Compensada
                                    @endif</td>
                                <td>{{ $solicitacao->created_at->format('d/m/Y') }}</td>
                                <td>@if($solicitacao->status != 0)
                                        {{ $solicitacao->updated_at->format('d/m/Y') }}
                                    @endif</td>
                                <td class="text-white">
                                    @if($solicitacao->status == 0)
                                        <span class="badge bg-warning">Solicitado</span>
                                    @else
                                        @if($solicitacao->status == 1)
                                            <span class="badge bg-success">Aprovado</span>
                                        @else
                                            <span class="badge bg-danger">Recusado</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                {{ $banco->links() }}
                </div>
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
                },
                success: function(data) {
                    if(data.response === 200)
                    {
                        let horas = data.data.total_horas.split(':');
                        $('#show').html(`<span>`+ horas[0] +`</span> Horas e <span>`+ horas[1] +`</span> Minutos`);
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
        }
    });
</script>
