<style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-jet-nav-link href="{{ route('create_comunicado') }}" :active="request()->is('comunicados/criar')">
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
            <div class="ml-auto my-3">
                <button class="btn btn-danger" id="print">Imprimir</button>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pt-4 pb-4" id="printable">
                <div class="card" style="margin: 0 auto;width: 80%;">
                    <div class="card-body">
                        <img src="{{ asset('img/cabecalho.jpg') }}" style="max-width: 50%; margin: 0 auto">
                        <h2 class="mt-3 mb-4" style="text-align: center; font-size: 2rem;"><b>COMUNICADO INTERNO</b></h2>

                        <span>
                            Para:    {{ $comunicado->destino->nome }} <br>
                            Autor:   {{ $comunicado->autor->name }} <br>
                            <br>
                            Data:    {{ $comunicado->created_at->format('d/m/Y') }} às {{ $comunicado->created_at->format('h:i') }} <br>
                            Assunto: {{ $comunicado->assunto }} <br>

                            <textarea class="form-control-plaintext" rows="30" style="resize: none" readonly>{{ $comunicado->conteudo }}</textarea>


                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

    $('#print').on('click', function (){
        window.print();
    })

</script>
