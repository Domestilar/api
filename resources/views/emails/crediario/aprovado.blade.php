@component('mail::message')
# Olá {{$crediario->nome}}

Seu crediário foi aprovado!, agora você pode efetuar suas compras em uma de nossas lojas.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
