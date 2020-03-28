# Funcional-Health-challenge

GraphQL + Laravel challenge para Funcional Health e também para treinamento profissional.

Essa foi minha primeira vez utilizando GraphQL, já possuia experiência com REST e foi muito interessante experimentar essa linguagem que está crescendo muito. 

Utilizei o Lumen e o [wrapper do rebing](https://github.com/rebing/graphql-laravel) para fazer a integração com o GraphQL.

Usei scripts do Docker para containers de PHP 7.4, nginx e MySQL. 


# Documentação

Copie o arquivo .env.example
```
cp .env.example .env
```

Para subir os containers do docker execute o seguinte comando:
```
docker-compose up
```

Assim que os containers estiverem rodando, utilize o seguinte comando para executar as migrations
```
docker-compose exec app php artisan migrate
```
O app será levantado na seguinte url: http://localhost:8080


Execute o seguinte comando para rodar os testes:
```
docker-compose exec app vendor/bin/phpunit
```
