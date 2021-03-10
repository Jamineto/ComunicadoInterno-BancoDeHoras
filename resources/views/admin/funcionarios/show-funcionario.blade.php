<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edição de funcionários') }}
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
                        <th scope="col">Setor</th>
                        <th scope="col">Data da criação</th>
                        <th scope="col">Data da ultima alteração</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <form action="{{ route('update_funcionarios',$funcionario->matricula) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <tbody class="text-center">
                            <tr>
                                    <td class="align-middle">{{$funcionario->id}}</td>
                                    <td class="align-middle"><input class="form-control" type="text" name="nome" value="{{$funcionario->nome}}"></td>
                                    <td class="align-middle">
                                        <select class="custom-select" name="setor_id">
                                            @foreach($setores as $setor)
                                                <option @if($setor->nome == $funcionario->setor->nome) selected @endif value="{{$setor->id}}">{{$setor->nome}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="align-middle">{{$funcionario->created_at->format('d/m/Y h:i')}}</td>
                                    <td class="align-middle">{{$funcionario->updated_at->format('d/m/Y h:i')}}</td>
                                    <td><a class="btn btn-secondary mr-2" href="{{ route('search_funcionarios') }}">Voltar</a><button type="submit" class="btn btn-info">Confirmar</button></td>
                            </tr>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
