<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comunicado de Banco de Horas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                <form method="post" action="{{ route('store_banco') }}">
                    @csrf
                    <input type="hidden" name="tipo" value="1">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nome do funcionário | Data de nascimento</label>
                            <select class="form-select form-control" name="funcionario_id" id="select" required>
                                <option value="x" selected>Selecione um funcionário</option>
                                @foreach($funcionarios as $funcionario)
                                <option value="{{$funcionario->matricula}}">{{$funcionario->nome}} | {{\Carbon\Carbon::createFromFormat('Y-m-d',$funcionario->data_nasc)->format('d/m/Y')}}</option>
                                @endforeach
                            </select>
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                Informe um funcionário.
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Setor</label>
                            <input type="text" class="form-control" name="origem_id" value="{{ Auth::user()->setor->nome }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Data</label>
                            <input type="text" class="form-control" id="datepicker" required>
                        </div>
                        <div class="form-group col-md-8">
                            <div class="form-row align-items-center">
                                <div class="form-group col-md-2">
                                    <label>Horário</label>
                                    <input type="time" class="form-control" id="horario_ini" required/>
                                </div>
                                <div class="form-check p-0 mx-2">
                                    <label class="form-check-label mt-3">
                                        às
                                    </label>
                                </div>
                                <div class="form-group col-md-2">
                                    <div style="min-height: 24px; margin-bottom: 8px"> </div>
                                    <input type="time" class="form-control" id="horario_fim" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Total</label>
                                    <input type="text" class="form-control disabled" id="total" disabled/>
                                </div>
                                <input type="text" class="hidden" id="data_ini" name="data_ini" value="">
                                <input type="text" class="hidden" id="data_fim" name="data_fim" value="">
                                <input type="text" class="hidden" id="total2" name="total" value="">
                            </div>
                        </div>



                    </div>
                    <div class="form-group">
                        <label>Justificativa</label>
                        <textarea class="form-control" name="justificativa" required></textarea>
                    </div>
                    <a href="{{url()->previous()}}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-info float-right">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    var picker = new Pikaday(
    {
        field: document.getElementById('datepicker'),
        format: 'DD/MM/YYYY',
        i18n: {
            previousMonth: 'Mês anterior',
            nextMonth: 'Próximo mês',
            months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
            weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
        }
    })
</script>

<script>
    $('form').on('submit', function (){
        if($('#select').val() === "x")
        {
            event.preventDefault();
            $('#validationServer03Feedback').show();
        }
    })

    $('#horario_fim').on('change',function (){
        let horarioi = $('#horario_ini').val().toString();
        let horariof = $('#horario_fim').val().toString();
        let data = $('#datepicker').val().toString().split('/');
        let earlierDateTime =  $('#datepicker').val() + ' ' + horarioi + ':00';
        if(horariof < horarioi)
            data[0] = parseInt(data[0]) + 1;
        let dataa = data.toString().replaceAll(',','/');
        let laterDateTime = dataa + ' ' + horariof + ':00';
        let difference = moment(laterDateTime, "DD/MM/YYYY HH:mm").diff(moment(earlierDateTime, "DD/MM/YYYY HH:mm"))
        let diff = moment.utc(difference).format("HH:mm");
        let sep = diff.split(':');
        $('#total').val(sep[0] + " Horas e " + sep[1] + " Minutos");
        $('#total2').val(diff);
        $('#data_ini').val(earlierDateTime.replaceAll('/','-'));
        $('#data_fim').val(laterDateTime.replaceAll('/','-'));
    });

</script>

