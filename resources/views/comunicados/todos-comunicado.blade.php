<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-jet-nav-link href="{{ route('create_comunicado') }}" :active="request()->is('/comunicados/criar')">
                {{ __('Enviar um comunicado') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('all_comunicados') }}" :active="request()->is('comunicados/todos')">
                {{ __('Comunicados não visualizados') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('viewed_comunicados') }}" :active="request()->is('comunicados/visualizados')">
                {{ __('Comunicados já visualizados') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('sent_comunicados') }}" :active="request()->is('comunicados/enviados')">
                {{ __('Comunicados enviados') }}
            </x-jet-nav-link>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('error'))

                <div class="alert alert-danger alert-block">

                    <strong>{{ $message }}</strong>

                </div>

            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-responsive table-hover text-center">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Assunto</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Origem</th>
                        <th scope="col">Data</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    @if(isset(Auth::user()->setor_id))
                        @if($comunicados != null)
                            @foreach($comunicados as $comunicado)
                                <tr>
                                    <td class="align-middle text-left"><a href="{{ route('show_comunicado',$comunicado->id) }}">{{strlen($comunicado->assunto) > 40 ? substr($comunicado->assunto,0,40)."..." : $comunicado->assunto}}</a></td>
                                    <td class="align-middle">{{$comunicado->autor->name}}</td>
                                    <td class="align-middle">{{$comunicado->origem->nome}}</td>
                                    <td class="align-middle">{{$comunicado->created_at->format('d/m/Y')}} às {{ $comunicado->created_at->format('h:i') }}</td>
                                    <td class="align-middle"><button type="button" class="btn btn-info m-0" id="visualizar" num="{{$comunicado->id}}">Marcar como visto</button></td>
                                </tr>
                            @endforeach
                        @else
                        <tr style="background-color: white;">
                            <td class="align-middle" colspan="6"> <h2 class="mt-4"> Não há nada para o seu setor! </h2> <br> <a class="btn btn-info mt-3" href="{{ route('viewed_comunicados') }}">Ver os comunicados já visualizados</a></td>
                        </tr>
                        @endif
                    @else
                        <tr style="background-color: white;">
                            <td class="align-middle" colspan="6">
                                <div class="alert alert-danger" role="alert">
                                    Seu setor ainda não foi designado, contate o administrador do sistema!
                                </div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $('table button').on('click',function( event ){
        event.preventDefault();
        var id = $(this).attr('num');
        var url = '{{ route('mark_viewed',":id") }}';
        var botao = $(this);
        var token = '{{ csrf_token() }}';
        var table = $('tbody');
        url = url.replace(':id',id);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {'_token' : token},
            beforeSend: function () {
                botao.attr('disabled',"disabled").html('<i class="fa fa-spinner fa-spin" id="loading">');
            },
            success: function(data) {
                botao.removeAttr("disabled","disabled");
                if(data.response === 200)
                {
                    botao.closest('tr').fadeOut();
                    botao.closest('tr').remove();
                    if(table.children().length === 0)
                    {
                        table.html(`<tr style="background-color: white;"><td class="align-middle" colspan="6"><i class="fa fa-spinner fa-spin fa-2x" id="loading"></td></tr>`)
                        setTimeout(function () {
                            table.html(`<tr style="background-color: white;"><td class="align-middle" colspan="6"> <h2 class="mt-4"> Não há nada para o seu setor! </h2> <br> <a class="btn btn-info mt-3" href="{{ route('viewed_comunicados') }}">Ver os comunicados já visualizados</a></td></tr>`)
                        },500);
                    }

                }
                else
                    alert(data.mensagem);
            },
            error: function() {
                alert('Ocorreu um erro no sistema!');
                botao.text('Erro');
            }
        });
    });
</script>
