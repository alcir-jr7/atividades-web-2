Atividades de Desenvolvimento Web II

Este repositório foi criado para armazenar todas as atividades desenvolvidas na disciplina de Desenvolvimento Web II. 


Tecnologias Utilizadas

* Laravel — Framework principal do backend

* PHP — Linguagem base

* MySQL — Banco de dados

* Composer — Gerenciador de dependências PHP

* Blade — Template engine nativa do Laravel


Como Executar o Projeto

Clone este repositório:

```bash

git clone url-do-repositorio
```


Configure o arquivo .env:

```bash

cp .env.example .env
```


Abra o arquivo **.env** e configure a conexão com o seu banco de dados:

DB_CONNECTION=mysql           # Altere para o seu banco (mysql, sqlite)
DB_HOST=127.0.0.1
DB_PORT=3306                  # Altere para a porta do seu banco
DB_DATABASE=atividade_07      
DB_USERNAME=root              # Altere para o usuário do seu banco
DB_PASSWORD=Root@1234         # Altere para a senha do seu banco


Instale as dependências:
```bash

composer install
npm install
```


Execute as migrations para montar o banco de dados:
```bash

php artisan migrate
```


Gere a chave da aplicação:
```bash

php artisan key:generate
```


Criar link simbólico para imagens
Caso o projeto contenha uploads de imagens, é necessário criar o link:
```bash

php artisan storage:link
```


Execute o servidor:
```bash

composer run dev
```

Após rodar, acesse o link mostrado no terminal geralmente (http://127.0.0.1:8000)
