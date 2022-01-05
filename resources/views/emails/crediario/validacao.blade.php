@component('mail::message')
# Olá {{$crediario->nome}},

Seu cadastro foi validado com suceso, clique no botão abaixo e complete seu cadastro.

@component('mail::button', ['url' => env('APP_URL')."/cadastro/{$crediario->uuid}/completar"])
Completar meu cadastro
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
