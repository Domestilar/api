@component('mail::message')
# Olá {{ $crediario->nome }},

Infelizmente não foi possível aprovar seu cadastro, segue o motivo abaixo: <br>

<b>Motivo:</b> {{ $crediario->motivo_rejeicao }}

@php
$documentos_rejeitados = $crediario
    ->anexos()
    ->where('status', 'REJEITADO')
    ->get();
@endphp

@if (count($documentos_rejeitados) > 0)
<b>Documentos Rejeitados/Motivo:</b>

<ul>
@foreach ($documentos_rejeitados as $c)
@php
$c->update(['notificado' => true]);   
@endphp
<li>{{ $c->tipo }} ({{ $c->motivo_rejeicao }});</li>
@endforeach
</ul>

@endif

Tente reenviar os dados clicando no botão abaixo:

@component('mail::button', ['url' => env('APP_URL')."/reenviar/{$crediario->uuid}"])
    Reenviar
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
