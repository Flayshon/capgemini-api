# Desafio Capgemini

## Ferramentas auxiliares
    O pacote [laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) foi usado como dev-dependecy para facilitar o uso no vscode.
    O banco foi persistido com sqlite conforme solicitado, mas normalmente eu usaria a abstração do Docker Compose oferecida pelo pacote [Vessel](https://vessel.shippingdocker.com/).
    Os testes de CI são realizados pela ferramenta GitHub Actions.

## Escolhas de arquitetura

### Backend

    - Foram incluídos Feature tests e Model factories utilizando o Faker para geração de dados de teste
    - As migrations foram definidas de modo a permitir que cada usuário possa ter várias contas bancárias, sobre as quais atuam diversas transações
    - Valores monetários são persistidos em centavos, visando maior portabilidade entre os diversos SGBDs disponíveis
    - Os tipos de transação (depósito e saque) foram definidas no TransactionsController
    - As transações são computadas no controller usando a facade DB::transaction() para evitar inconsistências
    - Cada transação realizada é persistida numa tabela dedicada de transações, possibilitando que sejam desfeitas mediante a implementação de uma funcionalidade futura
    - Utilizou-se o mecanismo autenticação padrão com 'auth' middleware e sessão com web driver
    - Foi incluso também o pacote/middleware/migrations do Laravel Sanctum, caso haja intenção de utilizar autenticação token-based
    - Ao registrar um novo usuário no frontend, uma nova conta é criada automaticamente com saldo 0

### Frontend

    - Como as operações solicitadas poderiam ser realizadas em uma única tela, optou-se por utilizar apenas um único Vue component para fins de simplicidade e eficiência.
    - Os elementos do componente foram estilizados com Bootstrap, aproveitando a estrutura oferecida pelo pacote laravel/ui
    - As chamadas à API foram realizadas com o client Axios
    - A cada transação, os componentes reativos são atualizados sem page reload