📘 Atividades de Desenvolvimento Web II

Este repositório foi criado para armazenar todas as atividades desenvolvidas na disciplina de Desenvolvimento Web II. 


✨ Tecnologias Utilizadas

* Laravel — Framework principal do backend

* PHP — Linguagem base

* MySQL — Banco de dados

* Composer — Gerenciador de dependências PHP

* Blade — Template engine nativa do Laravel


🚀 Como Executar o Projeto

1 - Clone este repositório:

```bash

git clone url-do-repositorio
```


2 - Configure o arquivo .env:

```bash

cp .env.example .env
```


3 - Abra o arquivo **.env** e configure a conexão com o seu banco de dados


4 - Instale as dependências:
```bash

composer install
```
```bash

npm install
```

5 - Execute as migrations para montar o banco de dados:
```bash

php artisan migrate
```


6 - Gere a chave da aplicação:
```bash

php artisan key:generate
```


7 - Criar link simbólico para imagens
Caso o projeto contenha uploads de imagens, é necessário criar o link:
```bash

php artisan storage:link
```


8 - Execute o servidor:
```bash

composer run dev
```

Após rodar, acesse o link mostrado no terminal geralmente (http://127.0.0.1:8000)
