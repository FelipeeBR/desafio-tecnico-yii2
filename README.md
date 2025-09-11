# Desafio Tecnico Yii2

API RESTful utilizando Yii2 para gerenciar despesas pessoais. O sistema permitirá aos usuários registrar, visualizar, editar, excluir e filtrar despesas.

### Instruções para Instalação e Execução

1. Clone o repositorio
   ```
   git clone https://github.com/FelipeeBR/desafio-tecnico-yii2
   cd desafio-tecnico-yii2
   ```
2. Conferir se precisar instalar dependencias:
   ```
   composer install
   ```
3. Criar os serviços no Docker
   ```
   docker compose up -d
   ```
   Aguarde a instalação dos serviços
   
4. Depois disso, execute o comando de migrate dentro do container PHP
   ```
   docker-compose exec php php yii migrate
   ```
5. Se tudo ocorreu bem, a aplicação já está disponivel.

### Decisões Tecnicas
#### Separação de responsabilidades:
- Decisão: Criar classes separadas (User, UserService, UserController, UserIdentityService) para dividir as responsabilidades.
  - User: Responsável por apenas modelagem e regras da entidade.
  - UserService: Para regras de negocio (Exemplo: CreateUser)
  - UserController: Responsável pelos endpoints Restful
  - UserItentityService: Responsável unicamente pela autenticação do usuario

#### Desabilitar o endpoint padrão de create em UserController:
```
public function actions() {
    $actions = parent::actions();
    
    unset($actions['create']);
    return $actions;
}
```
- Decisão: Foi necessário para implementar uma logica de cadastrar usuario. Em um caso futuro possa surgir novas funcionalidades, como por exemplo,
o usuario ter um perfil, seria mais facil preencher algumas informações para o perfil do usuario (uma entidade Profile) chamando os serviços de Profile no metodo de criar usuario.

#### Injeção de dependência PasswordHasher:
- Decisão: Antes para encriptar a senha do usuario, era tratado diretamente na entidade User chamando o método setPassword. Foi tirado essa reponsabilidade da entidade User.
O User requisita o serviço de encriptar a senha ao inves de fazer esse serviço. No caso o PasswordHasherService vai fazer isso.

#### Desativar CRUD padrão de Despesas (Expense):
```
public function actions() {
  $actions = parent::actions();
  
  unset($actions['index'], $actions['create'], $actions['update'], $actions['delete'], $actions['view']);
  return $actions;
}
```
- Decisão: Foi desativado a maneira padrão de CRUD de despesas para tratar melhor as validações, como:
  - ActionIndex: Consegue filtrar as depesas com searchModel, como tambem a maneira do usuario visualizar somente suas despesas.
  - ActionCreate: Para criar uma despesa precisa do id do usuario autenticado.
  - ActionUpdate: Para atualizar dados de uma despesa precisa do id do usuario autenticado.
  - ActionDelete: Só permite deleções de despesas do usuario autenticado.
  - ActionView: Visualiza detalhes de despesas do usuario autenticado.  

#### Links:
```
public function getLinks(): array {
  return [
      Link::REL_SELF => Url::to(['/api/expense/view', 'id' => $this->id], true),
      'update' => Url::to(['/api/expense/update', 'id' => $this->id], true),
      'delete' => Url::to(['/api/expense/delete', 'id' => $this->id], true),
  ];
}
```
- Decisão: Para saber quais ações da entidade User/Expense estão disponiveis (view, update, delete), foi implementado
o método getLinks() para uma melhor interação com a API, que é um principio de Restful.

### Testes

1. Fazer o build com:
   ```
   docker exec -it app_gerencia php vendor/bin/codecept build
   ```
   obs: esse projeto não está configurado banco de dados para testes, está sendo no DB principal.
   
2. Execute comandos para teste API:
   ```
   docker exec -it app_gerencia php vendor/bin/codecept run api UserCest
   ```
   ```
   docker exec -it app_gerencia php vendor/bin/codecept run api AuthCest
   ```
   ```
   docker exec -it app_gerencia php vendor/bin/codecept run api ExpenseCest
   ```

## Especificações de API: <a href="https://github.com/FelipeeBR/desafio-tecnico-yii2/blob/main/API.md">API.md</a>
