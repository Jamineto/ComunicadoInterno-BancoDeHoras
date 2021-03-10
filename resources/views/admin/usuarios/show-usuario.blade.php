<x-guest-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if ($message = Session::get('success'))

            <strong>{{ $message }}</strong>

        @endif
        @if ($message = Session::get('error'))

            <div class="alert alert-danger alert-block">

                <strong>{{ $message }}</strong>

            </div>

        @endif
        <form method="POST" action="{{ route('update_usuario',$usuario->id) }}">
            @csrf
            @method('PUT')
            <div>
                <x-jet-label for="name" value="{{ __('Nome') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" value="{{$usuario->name}}"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="username" value="{{ __('Nome de Usuário') }}" />
                <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username" value="{{ $usuario->username }}" />
            </div>
            <div class="mt-4">
                <x-jet-label for="setor" value="{{ __('Setor') }}" />
                <select class="form-select" name="setor_id">
                    @if(Auth::user()->setor == null)
                        <option selected>Selecionar setor</option>
                    @endif
                    @foreach($setores as $setor)
                        <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email (Opcional)') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $usuario->email }}" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Senha nova') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password_new" autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmação de senha') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
            </div>

            <div class="form-check mt-4">
                <input class="form-check-input" type="radio" name="admin" id="exampleRadios1" value="1" @if($usuario->admin == 1) checked @endif>
                <label class="form-check-label" for="exampleRadios1">
                    Administrador do Sistema
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="admin" id="exampleRadios2" value="2" @if($usuario->admin == 2) checked @endif>
                <label class="form-check-label" for="exampleRadios2">
                    Supervisor Geral
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="admin" id="exampleRadios3" value="0" @if($usuario->admin == 0) checked @endif>
                <label class="form-check-label" for="exampleRadios3">
                    Chefe de Setor
                </label>
            </div>

            <div class="mt-4" style="float: left">
                <x-jet-secondary-button class="ml-0" id="volta">
                    {{ __('Voltar') }}
                </x-jet-secondary-button>
            </div>
            <div class="mt-4" style="float: right">
                <x-jet-button class="mr-0">
                    {{ __('Atualizar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>

<script type="text/javascript">
    document.getElementById("volta").onclick = function () {
        location.href = "{{ route('search_usuarios') }}"
    };
</script>
