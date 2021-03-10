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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-responsive table-hover text-center">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Assunto</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Origem</th>
                        <th scope="col">Data</th>
                        @if(!Request::is('admin/*'))
                            <th scope="col">Ações</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @if(isset(Auth::user()->setor_id))
                        @if($comunicados->count() > 0)
                            @foreach($comunicados as $comunicado)
                                <tr>
                                    <td class="align-middle text-left" style="max-width: 250px; text-overflow: fade"><a href="{{ route('show_comunicado',$comunicado->id) }}">{{strlen($comunicado->assunto) > 40 ? substr($comunicado->assunto,0,40)."..." : $comunicado->assunto}}</a></td>
                                    <td class="align-middle">{{$comunicado->autor->name}}</td>
                                    <td class="align-middle">{{$comunicado->origem->nome}}</td>
                                    <td class="align-middle">{{$comunicado->created_at->format('d/m/Y')}} às {{ $comunicado->created_at->format('h:i') }}</td>
                                    @if(!Request::is('admin/*'))
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-info m-0 " num="{{$comunicado->id}}">Marcar como não visto</button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr style="background-color: white;">
                                @if(!Request::is('admin/*'))
                                    <td class="align-middle" colspan="6"> <h2 class="mt-4"> Você ainda não marcou nenhum comunicado como visualizado! </h2></td>
                                @else
                                    <td class="align-middle" colspan="6"> <h2 class="mt-4"> Nenhum comunicado enviado! </h2></td>
                                @endif
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
                <hr>
                {{ $comunicados->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $('table button').on('click',function( event ){
        event.preventDefault();
        var id = $(this).attr('num');
        var url = '{{ route('mark_not_viewed',":id") }}';
        var botao = $(this);
        var token = '{{ csrf_token() }}';
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
                    //alert(data.mensagem);
                    botao.closest('tr').fadeOut();
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
