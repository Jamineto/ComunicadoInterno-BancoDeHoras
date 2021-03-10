<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-jet-nav-link href="{{ route('create_banco_horas') }}" :active="request()->is('/bancodehoras/criar')">
                {{ __('Comunicado de banco de horas') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="{{ route('warning_compensada') }}" :active="request()->is('comunicados/todos')">
                {{ __('Comunicado de compensada') }}
            </x-jet-nav-link>
            @if(Auth::user()->admin == 1 || Auth::user()->admin == 2)
                <x-jet-nav-link href="{{ route('solicitacoes_banco') }}" :active="request()->is('comunicados/solicitacoes')">
                    {{ __('Solicitações de funcionários') }}
                </x-jet-nav-link>
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="col-md-4 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3 text-center">
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
                <form class="mb-3">
                    <label>Filtrar por: </label>
                    <select class="form-select form-control" id="selecionado">
                        <option></option>
                        @foreach($filtros as $filtro)
                            <option value="{{ $filtro->id }}">{{ isset($filtro->nome) ? $filtro->nome : $filtro->name }}</option>
                        @endforeach
                    </select>
                </form>
                    <a href="" class="btn btn-info" id="visualiza">Visualizar</a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
<script>

    $('#selecionado').on("change",function(){
        var filtro = $(this).val();
        var url2 = "{{ Request::url() }}";
        url2 = url2.split('/');
        console.log(url2);
        if(url2[4] === "comunicados")
        {
            var url = '{{route('admin_comunicados',[":filtro",":id"])}}';
            url = url.replace(':filtro',"{{isset($filtro->nome) ? "setor" : "usuario"}}")
        }
        else
        {
            var url = '{{route('admin_banco',":id")}}';
        }
        url = url.replace(':id',filtro);
        $('#visualiza').attr("href",url);
    });
</script>
