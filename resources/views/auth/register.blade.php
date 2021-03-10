<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Nome') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="username" value="{{ __('Nome de Usuário') }}" />
                <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username" placeholder="Ex: santacasa" :value="old('username')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email (Opcional)') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Senha') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmação de senha') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="form-check mt-4">
                <input class="form-check-input" type="radio" name="admin" id="exampleRadios1" value="1">
                <label class="form-check-label" for="exampleRadios1">
                    Administrador do Sistema
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="admin" id="exampleRadios2" value="2">
                <label class="form-check-label" for="exampleRadios2">
                    Supervisor Geral
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="admin" id="exampleRadios3" value="0">
                <label class="form-check-label" for="exampleRadios3">
                    Chefe de Setor
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Registrar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
