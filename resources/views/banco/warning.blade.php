<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-jet-nav-link href="{{ route('create_banco_horas') }}" :active="request()->is('/bancodehoras/criar')">
                {{ __('Comunicado de banco de horas') }}
            </x-jet-nav-link>
            <x-jet-nav-link href="" :active="request()->is('bancodehoras/aviso')">
                {{ __('Comunicado de compensada') }}
            </x-jet-nav-link>
            @if(Auth::user()->admin == 1 || Auth::user()->admin == 2)
                <x-jet-nav-link href="{{ route('solicitacoes_banco') }}" :active="request()->is('bancodehoras/solicitacoes')">
                    {{ __('Solicitações') }}
                </x-jet-nav-link>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="col-md-5 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <div class="alert alert-warning alert-block">
                    <strong>Comunicar a compensada ao RH 48 horas antes de sair, salvo urgência e emergência. <br>
                        Só é autorizado compensar 2 dias consecutivos. </strong>
                </div>
            <a href="{{url()->previous()}}" class="btn btn-secondary">Voltar</a>
            <a href="{{url(route('create_compensada'))}}" class="btn btn-info float-right">Estou ciente!</a>
            </div>
        <div>
    </div>
</x-app-layout>
