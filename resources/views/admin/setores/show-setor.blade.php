<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edição de Setor') }}
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
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Data da criação</th>
                        <th scope="col">Data da ultima alteração</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <form action="{{ route('update_setor',$setor->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <tbody class="text-center">
                            <tr>
                                    <td class="align-middle">{{$setor->id}}</td>
                                    <td class="align-middle"><input class="form-control" type="text" name="nome" value="{{$setor->nome}}"></td>
                                    <td class="align-middle">{{$setor->created_at->format('d/m/Y h:i')}}</td>
                                    <td class="align-middle">{{$setor->updated_at->format('d/m/Y h:i')}}</td>
                                    <td><button type="submit" class="btn btn-info mr-2">Confirmar</button><a class="btn btn-secondary" href="{{ route('search_setores') }}">Voltar</a> </td>
                            </tr>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
