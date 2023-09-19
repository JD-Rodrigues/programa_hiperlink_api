<p align="center">
  <img width=300 src="https://raw.githubusercontent.com/JD-Rodrigues/public-assets/main/Logos/api.png" />
</p>

## 📋 Descrição:
<p>Hiper Pass é uma estrutura backend para um sistema que gerencia usuários, eventos e ingressos adquiridos.</p>


## 🎯 Motivação:
O projeto teve como objetivo a realização de um teste técnico.

## 🟡 Status do projeto:
Sob análise.

## 🛠️ Funcionalidades já desenvolvidas:
- Autenticação de usuário;
- Cadastro, remoção, edição e listagem de usuários;
- Cadastro, remoção, edição e listagem de eventos;
- Cadastro e listagem de ingressos adquiridos.
- Fornece uma API com endpoints para todas as operações.
  
## 🔭 Tecnologias utilizadas:
<b>MySQL Server</b> - Sistema de gerenciamento de banco de dados utilizado na persistência das informações.
<b>Laravel</b> - Framework PHP utilizado na construção da API.

## Como rodar a aplicação:
### Requisitos:
- PHP 7.4 ou superior
- Ter o Composer instalado na máquina

### passo a passo:
1. Clone o Repositório:
- Abra o terminal ou prompt de comando e navegue até o diretório onde deseja armazenar o projeto.
- Use o comando `git clone git@github.com:JD-Rodrigues/programa_hiperlink_api.git`
2. Instale as dependências:
- Navegue até o diretório do projeto recém-clonado, usando o terminal.
- Execute o comando `composer install` para instalar as dependências do projeto Laravel listadas no arquivo composer.json.
3. Configure o banco de dados:
- Configure seu banco de dados no arquivo `.env`.
- Execute o comando `php artisan migrate` para criar as tabelas do banco de dados.
4. Rodando a aplicação localmente:
- Você pode usar o servidor de desenvolvimento do Laravel para executar o projeto localmente. Execute o comando `php artisan serve`.
5. Acessando a aplicação:
- Abra um navegador da web e acesse http://localhost:8000 (ou o endereço configurado para o servidor, que estará aparecendo na janela do terminal em que ele foi inicializado).


## Autenticação:
A autenticação é feita via token. É necessário incluir um token no header `Authorization`. O valor enviado neste header deve ser composto da palavra `Bearer` seguida de espaço e o token retornado no momento do login do usuário. Ex.:
`Bearer 2|x45fdsashdushduiayouioduisfiseroiserusirsicr`

## Endpoints

### -- Usuários --
`POST api/login` - Faz login, utilizando as seguintes informações de usuário obrigatórias enviadas via corpo da requisição (não requer autenticação):
`email`: endereço de email em formato padrão
`password`: string
Retorna um token de autenticação, requerido na maioria dos endpoints. É recomendado adicionar este token no header `Àuthorization` logo após recebê-lo, para que ele não seja perdido.

`POST api/logout` - Faz logoff na aplicação (requer autenticação). 

`GET api/users` - Lista todos os usuários cadastrados (requer autenticação).

`GET api/users/{id}` - Exibe o usuário cujo id for passado no parâmetro da url ()

`POST api/users` - Cadastra um novo usuário, com as seguintes informações obrigatórias enviadas no corpo da requisição, no formato JSON (não requer autenticação):
`name`: string
`email`: endereço de email em formato padrão
`password`: string
`authorize_location`: booleano (0 para verdadeiro ou 1 para falso)

`PUT api/users/{id}` - Atualiza o usuário cujo id for passado no parâmetro da url. As informações a serem atualizadas são enviadas no corpo da requisição, a saber: `name`, `email`, `password` e `authorize_location`. O id é o único dado obrigatório nessa requisição (requer autenticação).

`DELETE api/users/{id}` - Remove o usuário cujo id for passado no parâmetro da url (requer autenticação). 

### -- Eventos --
`GET api/events` - Lista todos os eventos (requer autenticação)

`GET api/events/{id}` - Exibe o evento cujo id for passado no parâmetro da url - (requer autenticação)

`POST api/events` - Cadastra um novo evento, com as seguintes informações obrigatórias enviadas no corpo da requisição, no formato JSON (requer autenticação):
`title`: string
`image`: nome da imagem com extensão. Ex.: `evento.png`
`start_date`: data em formato YYYY-MM-DD.


`PUT api/events/{id}` - Atualiza o evento cujo id for passado no parâmetro da url. As informações a serem atualizadas são enviadas no corpo da requisição, a saber: `title`, `image` e `start_date`. O id é o único dado obrigatório nessa requisição. Requer autenticação.

`DELETE api/events/{id}` - Remove o evento cujo id for passado no parâmetro da url (requer autenticação).

### -- Ingressos --
`GET api/tickets` - Lista todos os ingressos já adquiridos (requer autenticação).

`POST api/tickets` - Cadastra um novo ingresso, com as seguintes informações obrigatórias enviadas no corpo da requisição, no formato JSON (requer autenticação):
`id_user`: number
`id_event`: number





    