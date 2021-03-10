@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ url('https://lh3.google.com/u/0/d/15RBNSGfaVMWZZOUANBNmL2xuvp2ktPG5=w1920-h966-iv1') }}" style="width: 150px;height: 150px" alt="Santa Casa Logo">
@endcomponent
@endslot

{{-- Body --}}
<!-- Body here -->
# Notificação por e-mail

Existe um novo comunicado interno para o seu setor!

@component('mail::panel')
* Assunto: {{$assunto}}
* Autor: {{$autor}}
@endcomponent
@component('mail::button', ['url' => route('show_comunicado',$id)])
Ver comunicado
@endcomponent
{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')
Lembre-se que o site funciona apenas na rede da santa casa.
@endcomponent
@endslot


{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
@endcomponent
@endslot
@endcomponent
