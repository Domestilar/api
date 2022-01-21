@component('mail::message')
# Olá {{$crediario->nome}},

Sua solicitação para abertura de crediário foi solicitada, seu número de protocolo é {{$crediario->id}}, em breve retornaremos seu contato.

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
