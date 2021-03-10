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
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-responsive table-hover text-center">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Assunto</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Destino</th>
                        <th scope="col">Data</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @if(isset(Auth::user()->setor_id))
                        @if($comunicados->count() > 0)
                            @foreach($comunicados as $comunicado)
                                <tr>
                                    <td class="align-middle text-left"><a href="{{ route('show_comunicado',$comunicado->id) }}">{{strlen($comunicado->assunto) > 40 ? substr($comunicado->assunto,0,40)."..." : $comunicado->assunto}}</a></td>
                                    <td class="align-middle">{{$comunicado->autor->name}}</td>
                                    <td class="align-middle">{{$comunicado->destino->nome}}</td>
                                    <td class="align-middle">{{$comunicado->created_at->format('d/m/Y')}} às {{ $comunicado->created_at->format('h:i') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr style="background-color: white;">
                                <td class="align-middle" colspan="5"> <h2 class="mt-4"> Você ainda não enviou nenhum comunicado! </h2></td>
                            </tr>
                        @endif
                    @else
                        <tr style="background-color: white;">
                            <td class="align-middle" colspan="5">
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
