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
                <form action="{{ route('importaFunc') }}" method="post" class="m-3" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Arquivo de funcionarios</label>
                        <input type="file" class="form-control-file" name="arquivo" placeholder="Arquivo de funcionarios.txt">
                        <small id="fileHelpId" class="form-text text-muted">Selecione o arquivo com os funcionarios</small>
                    </div>
                    <a href="{{ route('admin_index') }}" class="btn btn-light">Voltar</a>
                    <x-jet-button style="float: right">Importar</x-jet-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
