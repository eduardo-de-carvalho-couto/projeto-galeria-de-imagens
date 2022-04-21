# Criar Ambiente de Desenvolvimento PHP com o Docker Compose

### Passo a passo
Faça uma cópia do arquivo .env.example
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME=Galeria
APP_ENV=dev
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=database_user
DB_PASSWORD=password
...
```
Atualize a variável DB_HOST. E se for de sua preferência, mude também o database name, username e o password.


Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```
