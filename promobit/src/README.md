<h1>Tecnologias utilizadas</h1>
<ul>
    <li>Laravel</li>
        <ol> 
            <li>Laravel Jetstream(Autenticação)</li>
            <li>Laravel Passport(API OAuth 2.0)</li>
        </ol>
</ul>

<h1>Instruções para instalação:</h1>

Após a clonagem do repositório, fazer a instalação do composer na raíz do projeto:
```
composer install
```

Rodar
```
npm install && npm run dev
```
Fazer a configuração do arquivo .env copiando o arquivo .env.example:
```
cp .env.example .env
```
Após a configuração do banco de dados em .env, executar as migrations:
```
php artisan migrate:fresh
```

Para geração das chaves de uso do passport:
```
php artisan passport:install
```

Caso a instalação do passport de erro siga os seguintes passos:
```
php artisan cache:clear
```

```
php artisan config:clear
```

```
composer dump-autoload
```
E se mesmo assim não der certo
![image](https://user-images.githubusercontent.com/71338619/130554717-6dd846c5-a48e-494a-8d15-a9ff5ec51bdd.png)

Exclua a linha 28
```
php artisan passport:install
```
E insira ela novamente
