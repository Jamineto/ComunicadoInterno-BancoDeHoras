<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Envio de comunicado') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                <form method="post" action="{{ route('store_comunicado') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Nome</label>
                            <input type="text" class="form-control" name="nome" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Setor</label>
                            <input type="text" class="form-control" name="origem_id" value="{{ Auth::user()->setor->nome }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Data</label>
                            <input type="text" class="form-control" name="data" value="{{date('d/m/Y')}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Assunto</label>
                        <input type="text" class="form-control" name="assunto" placeholder="" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Conteúdo</label>
                        <textarea class="form-control" rows="3" name="conteudo" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputState">Setor Destinado</label>
                            <select id="inputState" class="form-control" name="destino_id">
                                @foreach($setores as $setor)
                                    <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <a href="{{url()->previous()}}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-info float-right" id="envia">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    $('form').on('submit',function (){
        botao = $('#envia');
        botao.html(' <i class="fas fa-spinner fa-spin"></i> ');
        botao.addClass('disabled');
    });
</script>
