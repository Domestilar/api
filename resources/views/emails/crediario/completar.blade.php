@component('mail::message')
# Olá {{$crediario->nome}},

Parabéns, seus dados foram encaminhados setor responsável pela análise, em breve entraremos em contato com você.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
