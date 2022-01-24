#Domestilar Crediário - API


###Requisitos:
- php 7.4^
- composer -> https://getcomposer.org/

###Instalação:
Clonar projeto:
```
git clone https://github.com/Domestilar/api.git
```
Instalar dependências:
```
cd api 
composer install
```
Copie o .env.example:
```
cp .env.example .env
```
Configure o domínio da aplicação:
```
APP_URL=http://localhost:8081
API_URL=http://domestilar.api
```
Configure o banco de dados:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
Configure seu servidor de e-mails:
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

Rode os seguintes comandos:
```
php artisan key:generate
php artisan migrate
php artisan db:seed --class DatabaseSeeder
php artisan jwt:secret
```
Apontar o domínio da aplicação para o diretório **api/public**

Usuário e senha para acessar a aplicação:
**email**: administrador@domestilar.com
**senha**: 123456
