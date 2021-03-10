<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criação de setor') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                <div class="alert alert-info hidden" id="ok"  role="alert">
                </div>
                <div class="alert alert-danger hidden" id="error" role="alert">
                </div>
                <form>
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nome do setor</label>
                            <input type="text" class="form-control" name="nome">
                        </div>
                    </div>
                    <a href="{{url()->previous()}}" class="btn btn-secondary">Voltar</a>
                    <button id="enviar" class="btn btn-info float-right">Enviar</button>,
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $('#enviar').on('click',function( event ){
        event.preventDefault();
        let nome = $('[name="nome"]').val();
        let error = $('#error');
        let ok    = $('#ok');
        let token = '{{ csrf_token() }}';
        error.hide();
        ok.hide();
        $.ajax({
            url: '{{route('store_setor')}}',
            type: 'POST',
            dataType: 'json',
            data: {nome:nome,_token: token},
            beforeSend: function () {
                $('#enviar').attr('disabled',"disabled").html('<i class="fa fa-spinner fa-spin" id="loading">');
            },
            success: function(data) {
                console.log("sucesso");
                $('#enviar').text('Enviar');
                $('#enviar').removeAttr("disabled","disabled");
                if(data.response === 200)
                    ok.show().html(data.mensagem)
                else
                    error.show().html(data.mensagem)
            },
            error: function() {
                error.show().text('Ocorreu um erro no sistema!');
            }
        });
    });
</script>
