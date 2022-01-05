@component('mail::message')
# Olá {{$crediario->nome}},

Sua solicitação para abertura de crediário foi solicitada, em breve retornaremos seu contato.

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
