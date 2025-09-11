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

## Endpoint de Cadastro de Despesas

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

## Endpoint de Editar de Despesas

*   **Endpoint:** `/api/expense/{id}`
*   **Método:** `PUT`
*   **Descrição:** Edita despesa.

**Exemplo de Requisição**
*   **URL:** `http://localhost:8888/api/expense/6`

**Exemplo de Resposta (200 OK)**
```json
{
    "success": true,
    "data": {
        "id": 6,
        "user_id": 3,
        "category_id": 1,
        "description": "Test Atualizado",
        "amount": 999,
        "date": "2025-09-10",
        "created_at": "2025-09-11 01:06:55",
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

## Endpoint de Visualizar Despesas

*   **Endpoint:** `/api/expense`
*   **Método:** `GET`
*   **Descrição:** Visualizar Despesas.

**Exemplo de Requisição**
*   **URL:** `http://localhost:8888/api/expense`

**Exemplo de Resposta (200 OK)**
```json
{
    "items": [
        {
            "id": 4,
            "user_id": 3,
            "category_id": 1,
            "description": "Test",
            "amount": "200.00",
            "date": "2025-09-10",
            "created_at": "2025-09-11 01:05:17",
            "_links": {
                "self": {
                    "href": "http://localhost:8888/api/expense/4"
                },
                "update": {
                    "href": "http://localhost:8888/api/expense/4"
                },
                "delete": {
                    "href": "http://localhost:8888/api/expense/4"
                }
            }
        },
        {
            "id": 5,
            "user_id": 3,
            "category_id": 1,
            "description": "Test",
            "amount": "499.50",
            "date": "2025-09-10",
            "created_at": "2025-09-11 01:06:11",
            "_links": {
                "self": {
                    "href": "http://localhost:8888/api/expense/5"
                },
                "update": {
                    "href": "http://localhost:8888/api/expense/5"
                },
                "delete": {
                    "href": "http://localhost:8888/api/expense/5"
                }
            }
        },
        {
            "id": 6,
            "user_id": 3,
            "category_id": 1,
            "description": "Test Atualizado",
            "amount": "999.00",
            "date": "2025-09-10",
            "created_at": "2025-09-11 01:06:55",
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
    ],
    "_links": {
        "self": {
            "href": "http://localhost:8888/api/expense?page=1"
        },
        "first": {
            "href": "http://localhost:8888/api/expense?page=1"
        },
        "last": {
            "href": "http://localhost:8888/api/expense?page=1"
        }
    },
    "_meta": {
        "totalCount": 3,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}
```

## Endpoint de Filtrar Despesas por Categoria

*   **Endpoint:** `/api/expense?category_id={id}`
*   **Método:** `GET`
*   **Descrição:** Filtrar Despesas por Categoria.

**Exemplo de Requisição**
*   **URL:** `http://localhost:8888/api/expense?category_id=2`

**Exemplo de Resposta (200 OK)**
```json
{
    "items": [
        {
            "id": 7,
            "user_id": 3,
            "category_id": 2,
            "description": "Test",
            "amount": "499.50",
            "date": "2025-09-10",
            "created_at": "2025-09-11 01:20:53",
            "_links": {
                "self": {
                    "href": "http://localhost:8888/api/expense/7"
                },
                "update": {
                    "href": "http://localhost:8888/api/expense/7"
                },
                "delete": {
                    "href": "http://localhost:8888/api/expense/7"
                }
            }
        }
    ],
    "_links": {
        "self": {
            "href": "http://localhost:8888/api/expense?category_id=2&page=1"
        },
        "first": {
            "href": "http://localhost:8888/api/expense?category_id=2&page=1"
        },
        "last": {
            "href": "http://localhost:8888/api/expense?category_id=2&page=1"
        }
    },
    "_meta": {
        "totalCount": 1,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}
```

## Endpoint de Filtrar Despesas por Mês/Ano e Categoria

*   **Endpoint:** `/api/expense?month=9&year=2025&category_id={id}`
*   **Método:** `GET`
*   **Descrição:** Filtrar Despesas por Mês/ano e Categoria.

**Exemplo de Requisição**
*   **URL:** `http://localhost:8888/api/expense?month=9&year=2025&category_id=2`

**Exemplo de Resposta (200 OK)**
```json
{
    "items": [
        {
            "id": 7,
            "user_id": 3,
            "category_id": 2,
            "description": "Test",
            "amount": "499.50",
            "date": "2025-09-10",
            "created_at": "2025-09-11 01:20:53",
            "_links": {
                "self": {
                    "href": "http://localhost:8888/api/expense/7"
                },
                "update": {
                    "href": "http://localhost:8888/api/expense/7"
                },
                "delete": {
                    "href": "http://localhost:8888/api/expense/7"
                }
            }
        }
    ],
    "_links": {
        "self": {
            "href": "http://localhost:8888/api/expense?month=9&year=2025&category_id=2&page=1"
        },
        "first": {
            "href": "http://localhost:8888/api/expense?month=9&year=2025&category_id=2&page=1"
        },
        "last": {
            "href": "http://localhost:8888/api/expense?month=9&year=2025&category_id=2&page=1"
        }
    },
    "_meta": {
        "totalCount": 1,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}
```
