# Desafio Tecnico Yii2

API RESTful utilizando Yii2 para gerenciar despesas pessoais. O sistema permitirá aos usuários registrar, visualizar, editar, excluir e filtrar despesas.

### Instruções para Instalação e Execução

1. Clone o repositorio
   ```
   git clone https://github.com/FelipeeBR/desafio-tecnico-yii2
   cd desafio-tecnico-yii2
   ```
2. Criar os serviços no Docker
   ```
   docker compose up -d
   ```
   Aguarde a instalação dos serviços
   
3. Depois disso, execute o comando de migrate dentro do container PHP
   ```
   docker-compose exec php php yii migrate
   ```
4. Se tudo ocorreu bem, a aplicação já está disponivel.

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

#### Desativa CRUD padrão de Despesas (Expense):
```
public function actions() {
  $actions = parent::actions();
  
  unset($actions['index'], $actions['create'], $actions['update'], $actions['delete'], $actions['view']);
  return $actions;
}
```
- Decisão: 
