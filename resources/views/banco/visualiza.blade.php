<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($dados->tipo == 1)
                {{ __('Visualização de Banco de Horas') }}
            @else
                {{ __('Visualização de Compensada') }}
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Nº Registro</label>
                            <input class="form-control" value="{{ $dados->funcionario->matricula }}" readonly>
                        </div>
                        <div class="form-group col-md-8">
                            <label>Nome do funcionário</label>
                            <input class="form-control" value="{{ $dados->funcionario->nome }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Data de nascimento</label>
                            <input class="form-control" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d',$dados->funcionario->data_nasc)->format('d/m/Y') }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Setor</label>
                            <input type="text" class="form-control" name="origem_id" value="{{ $dados->funcionario->setor->nome }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Data início</label>
                            <input type="text" class="form-control" name="data" value="{{ $dados->data_ini->format('d/m/Y H:i') }}" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Data fim</label>
                            <input type="text" class="form-control" name="data" value="{{ $dados->data_fim->format('d/m/Y H:i') }}" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tempo total</label>
                            <input type="text" class="form-control" name="data" value="{{ $horas .' Horas e ' . $min . ' Minutos' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Justificativa</label>
                        <textarea class="form-control" name="justificativa" readonly>{{ $dados->justificativa }}</textarea>
                    </div>
                    <a href="{{url()->previous()}}" class="btn btn-secondary">Voltar</a>
                    <div class="float-right">
                    @if(Auth::user()->admin == 1 || Auth::user()->admin == 2 && $dados->status == 0)
                        <a href="{{ route('troca_status',[$dados->id,2]) }}" class="btn btn-danger">Recusar</a>
                        <a href="{{ route('troca_status',[$dados->id,1]) }}" class="btn btn-success ml-5">Aceitar</a>
                    @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

