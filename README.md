
# Criar Ambiente de Desenvolvimento PHP com o Docker Compose

### Passo a passo
Faça uma cópia do arquivo .env.example
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME=Travellist
APP_ENV=dev
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=travellist
DB_USERNAME=travellist_user
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


Se for de sua preferência, utilizar o MySQL Workbench para fazer a conexão com o banco de dados. Em seguida, crie o banco de dados e as tabelas
```sh
create table imagens(
    id int not null primary key AUTO_INCREMENT,
    id_usuario int not null,
    legenda varchar(100) not null,
    path varchar(100) not null,
    data datetime default current_timestamp
);

create table usuarios(
    id int not null primary key auto_increment,
    nome varchar(100) not null,
    email varchar(150) not null,
    senha varchar(32) not null
);

create table curtidas(
    id int not null primary key auto_increment,
    id_usuario int not null,
    id_usuario_curtindo int not null
);
```
