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
