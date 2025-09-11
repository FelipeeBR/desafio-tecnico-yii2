# API Despesas

Esta API permite gerenciar despesas.

## Endpoint de Registro de Usuários

*   **Endpoint:** `/api/user`
*   **Método:** `POST`
*   **Descrição:** Cadastra um novo usuário.

**Exemplo de Requisição**
*   **URL:** `http://localhost:8888/api/user`

**Exemplo de Resposta (201 Created)**
```json
{
    "success": true,
    "data": {
        "name": "John Doe",
        "email": "test@example.com",
        "access_token": "ZASV9tZoGYz5350wST2-bxWHUVutPBL6",
        "id": 3,
        "_links": {
            "self": {
                "href": "http://localhost:8888/api/user/3"
            },
            "update": {
                "href": "http://localhost:8888/api/user/3"
            },
            "delete": {
                "href": "http://localhost:8888/api/user/3"
            }
        }
    }
}
```

## Endpoint de Autenticação de Usuários

*   **Endpoint:** `/api/auth/login`
*   **Método:** `POST`
*   **Descrição:** Autentica Usuário.

**Exemplo de Requisição**
*   **URL:** `http://localhost:8888/api/auth/login`

**Exemplo de Resposta (200 OK)**
```json
{
    "success": true,
    "access_token": "ZASV9tZoGYz5350wST2-bxWHUVutPBL6",
    "user": {
        "id": 3,
        "name": "John Doe",
        "email": "test@example.com"
    },
    "_links": {
        "self": "http://localhost:8888/api/user/3",
        "update": "http://localhost:8888/api/user/3",
        "delete": "http://localhost:8888/api/user/3"
    }
}
```

## Endpoint de Autenticação de Usuários

*   **Endpoint:** `/api/expense`
*   **Método:** `POST`
*   **Descrição:** Cria uma nova despesa.

**Exemplo de Requisição**
*   **URL:** `http://localhost:8888/api/expense`

**Exemplo de Resposta (201 Created)**
```json
{
    "success": true,
    "data": {
        "user_id": 3,
        "category_id": 1,
        "description": "Test",
        "amount": 499.5,
        "date": "2025-09-10",
        "id": 6,
        "_links": {
            "self": {
                "href": "http://localhost:8888/api/expense/6"
            },
            "update": {
                "href": "http://localhost:8888/api/expense/6"
            },
            "delete": {
                "href": "http://localhost:8888/api/expense/6"
            }
        }
    }
}
```
