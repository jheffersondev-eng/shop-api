# 🛍️ Shop API

Um sistema moderno de gerenciamento de e-commerce construído com **Laravel 12**, **PHP 8.2** e **MySQL 8.0**. Desenvolvido com **Arquitetura Limpa** e **Domain-Driven Design** para oferecer uma experiência intuitiva, maintível e performance otimizada.

---

## 📋 Índice

- [🎯 Visão Geral](#-visão-geral)
- [🏗️ Arquitetura](#-arquitetura)
- [🔧 Tecnologias](#-tecnologias)
- [⚙️ Pré-requisitos](#️-pré-requisitos)
- [🚀 Guia de Instalação](#-guia-de-instalação)
- [📁 Estrutura do Projeto](#-estrutura-do-projeto)
- [🎮 Como Usar](#-como-usar)
- [🐳 Docker](#-docker)
- [📚 Endpoints Principais](#-endpoints-principais)
- [🧪 Testes](#-testes)
- [🐛 Troubleshooting](#-troubleshooting)
- [📖 Documentação Adicional](#-documentação-adicional)

---

## 🎯 Visão Geral

**Shop API** é uma plataforma completa de API para gerenciamento de e-commerce que inclui:

✅ **Gestão de Produtos** - Cadastro com múltiplas imagens e descrições detalhadas  
✅ **Gerenciamento de Usuários** - Sistema de autenticação com JWT e verificação de email  
✅ **Gestão de Categorias** - Organização e classificação de produtos  
✅ **Unidades de Medida** - Suporte a diferentes tipos de unidades (kg, m, l, etc)  
✅ **Perfis e Permissões** - Controle granular de acesso  
✅ **API REST Moderna** - Endpoints bem estruturados com validação robusta  
✅ **Arquitetura Limpa** - Separação clara de responsabilidades e fácil manutenção

---

## 🏗️ Arquitetura

O projeto segue **Clean Architecture** combinado com **Domain-Driven Design (DDD)** para máxima organização e escalabilidade:

```
src/
├── Api/                          # Camada de Apresentação (API)
│   ├── Controllers/              # Controladores HTTP
│   ├── Middleware/               # Middlewares (autenticação, validação)
│   ├── Requests/                 # Validação de requisições
│   ├── Responses/                # Formatação de respostas
│   ├── resources/                # Views e templates
│   └── routes/                   # Definição de módulos de rotas
│
├── Application/                  # Camada de Aplicação (Use Cases)
│   ├── Dto/                      # Data Transfer Objects
│   ├── Interfaces/               # Contratos de serviços e repositórios
│   ├── Services/                 # Lógica de negócio orquestrada
│   ├── UseCase/                  # Casos de uso específicos
│   ├── Exceptions/               # Exceções customizadas
│   ├── Mappers/                  # Mapeadores de dados
│   └── Support/                  # Classes utilitárias
│
├── Domain/                       # Camada de Domínio (Entidades e Regras)
│   ├── Entities/                 # Entidades do domínio
│   ├── Enums/                    # Enumerações
│   ├── DomainServices/           # Serviços de domínio
│   └── ValueObjects/             # Objetos de valor
│
└── Infrastructure/               # Camada de Infraestrutura
    ├── Persistence/              # Persistência de dados
    │   ├── Models/               # Modelos Eloquent
    │   └── Repositories/         # Implementação de repositórios
    ├── Providers/                # Service Providers
    ├── Mail/                     # Serviços de email
    └── External/                 # Integrações externas
```

### 🔄 Fluxo de Implementação

```
Routes Module
    ↓
Controller
    ↓
Requests (Validation)
    ↓
DTOs (Data Transfer Objects)
    ↓
Service (Interface + Implementação)
    ↓
User Case (Implementação Quando Necessário)
    ↓
Repository (Interface + Implementação)
    ↓
Mapper (Transformação de dados)
    ↓
Entities (Domínio)
    ↓
Exception (Erros específicos)
```

---

## 🔧 Tecnologias

### Backend
| Tecnologia | Versão | Descrição |
|-----------|--------|-----------|
| ![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?logo=laravel) | 12.0 | Framework PHP moderno |
| ![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php) | 8.2 | Linguagem backend |
| ![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql) | 8.0 | Banco de dados relacional |
| ![Laravel Sanctum](https://img.shields.io/badge/Laravel%20Sanctum-4.2-FF2D20?logo=laravel) | 4.2 | Autenticação API com tokens |

### Frontend / Build
| Tecnologia | Versão | Descrição |
|-----------|--------|-----------|
| ![Vite](https://img.shields.io/badge/Vite-7.0-646CFF?logo=vite) | 7.0 | Build tool moderno |
| ![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.0-06B6D4?logo=tailwindcss) | 4.0 | Framework CSS utilitário |
| ![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?logo=javascript) | ES6+ | Interatividade |
| ![Axios](https://img.shields.io/badge/Axios-1.11-671DDF?logo=axios) | 1.11 | Cliente HTTP |

### Desenvolvimento & Testes
| Ferramentas | Descrição |
|----------|-----------|
| 🐳 Docker | Containerização do banco de dados |
| 📦 Composer | Gerenciador de dependências PHP |
| 🧪 PHPUnit | Testes unitários e de integração |
| 🔧 Laravel Pint | Formatação de código PHP |
| 🧬 FakerPHP | Geração de dados fake para testes |
| 🎭 Mockery | Mocking para testes unitários |

### DevOps
| Ferramentas | Descrição |
|----------|-----------|
| 🐳 Docker | Containerização de serviços |
| 🚀 Nginx | Servidor web |
| ⚙️ Supervisor | Gerenciador de processos |

---

## ⚙️ Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **PHP 8.2+** ([Download](https://www.php.net/downloads))
- **Composer** ([Download](https://getcomposer.org/))
- **Docker Desktop** ([Download](https://www.docker.com/products/docker-desktop))
- **Node.js 18+** ([Download](https://nodejs.org/))
- **Git** ([Download](https://git-scm.com/))

### Verificar instalações:
```bash
php --version          # Deve mostrar PHP 8.2+
composer --version     # Deve mostrar Composer 2.x
docker --version       # Deve estar instalado
node --version         # Deve mostrar v18+
git --version          # Deve estar instalado
```

---

## 🚀 Guia de Instalação

### 1️⃣ Clonar o Repositório
```bash
git clone https://github.com/seu-usuario/shop-api.git
cd shop-api
```

### 2️⃣ Instalar Dependências PHP
```bash
composer install
```

### 3️⃣ Configurar Variáveis de Ambiente
```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure:
```env
APP_NAME="Shop API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_KEY=base64:SUA_CHAVE_AQUI

# Banco de dados (Docker)
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=shop_api
DB_USERNAME=root
DB_PASSWORD=shoppassword

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:8000,127.0.0.1:8000
SESSION_DRIVER=file
```

### 4️⃣ Gerar Chave da Aplicação
```bash
php artisan key:generate
```

### 5️⃣ Instalar Dependências Frontend
```bash
npm install
```

### 6️⃣ Iniciar o Docker
```bash
docker-compose up -d
```

Aguarde 10-15 segundos para o MySQL estar totalmente pronto.

### 7️⃣ Executar Migrações do Banco
```bash
php artisan migrate
```

### 8️⃣ Seeding (Opcional - Dados de Teste)
```bash
php artisan db:seed
```

### 9️⃣ Build Frontend
```bash
npm run build
```

Para desenvolvimento com hot reload:
```bash
npm run dev
```

### 🔟 Iniciar o Servidor Laravel
```bash
php artisan serve
```

A aplicação estará disponível em: **http://localhost:8000**

---

## 📁 Estrutura do Projeto

```
shop-api/
├── bootstrap/                  # Bootstrap da aplicação
│   ├── app.php                # Configuração da aplicação
│   ├── providers.php          # Providers
│   └── cache/                 # Cache de bootstrap
├── config/                    # Arquivos de configuração
│   ├── app.php               # Configuração da app
│   ├── auth.php              # Configuração de autenticação
│   ├── database.php          # Configuração de BD
│   └── ...
├── database/
│   ├── migrations/           # Migrações de banco de dados
│   ├── seeders/              # Seeds de dados iniciais
│   └── factories/            # Factories para testes
├── docker/                   # Configurações Docker
│   ├── nginx/                # Configuração Nginx
│   ├── php/                  # Configuração PHP-FPM
│   └── supervisor/           # Configuração Supervisor
├── public/
│   ├── index.php            # Entry point da aplicação
│   └── robots.txt           # Configuração de crawlers
├── resources/
│   ├── css/                 # Estilos CSS
│   ├── js/                  # Scripts JavaScript
│   └── views/               # Templates Blade
├── routes/                  # Definição de rotas (web)
├── src/
│   ├── Api/                 # Camada de Apresentação
│   │   ├── Controllers/     # Controladores HTTP
│   │   ├── Middleware/      # Middlewares
│   │   ├── Requests/        # Validação de entrada
│   │   ├── Responses/       # Formatação de respostas
│   │   ├── resources/       # Views
│   │   └── routes/          # Módulos de rotas
│   ├── Application/         # Camada de Aplicação
│   │   ├── Dto/            # Data Transfer Objects
│   │   ├── Interfaces/     # Contratos
│   │   ├── Services/       # Lógica de negócio
│   │   ├── UseCase/        # Casos de uso
│   │   ├── Exceptions/     # Exceções customizadas
│   │   ├── Mappers/        # Mapeadores de dados
│   │   └── Support/        # Classes utilitárias
│   ├── Domain/             # Camada de Domínio
│   │   ├── Entities/       # Entidades do domínio
│   │   ├── Enums/          # Enumerações
│   │   └── DomainServices/ # Serviços de domínio
│   ├── Infrastructure/     # Camada de Infraestrutura
│   │   ├── Persistence/    # Persistência de dados
│   │   │   ├── Models/     # Modelos Eloquent
│   │   │   └── Repositories/ # Repositórios
│   │   ├── Providers/      # Service Providers
│   │   ├── Mail/           # Serviços de email
│   │   └── External/       # Integrações externas
│   └── Console/            # Comandos artisan
├── storage/                # Cache, logs, uploads
│   ├── app/               # Arquivos da aplicação
│   ├── framework/         # Cache e sessões
│   └── logs/              # Logs da aplicação
├── tests/                 # Testes automatizados
│   ├── Feature/          # Testes de features
│   └── Unit/             # Testes unitários
├── .env.example           # Exemplo de variáveis
├── artisan                # CLI do Laravel
├── composer.json          # Dependências PHP
├── package.json           # Dependências Node
├── phpunit.xml            # Configuração de testes
├── vite.config.js         # Configuração Vite
└── README.md              # Este arquivo
```

---

## 🎮 Como Usar

### 📋 Fluxo Completo de API

#### 1. **Registrar um Usuário**
```http
POST /api/user/register
Content-Type: application/json

{
  "name": "João Silva",
  "email": "joao@example.com",
  "password": "senhaForte123"
}
```

#### 2. **Verificar Email**
Após o registro, um email de verificação será enviado. Use o código para verificar:
```http
POST /api/user/verify
Content-Type: application/json

{
  "email": "joao@example.com",
  "verification_code": "123456"
}
```

#### 3. **Login**
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "joao@example.com",
  "password": "senhaForte123"
}
```

Resposta:
```json
{
  "success": true,
  "data": {
    "token": "seu_token_jwt_aqui",
    "user": {
      "id": 1,
      "name": "João Silva",
      "email": "joao@example.com"
    }
  }
}
```

#### 4. **Criar uma Categoria** (Requer autenticação)
```http
POST /api/category/create
Content-Type: application/json
Authorization: Bearer SEU_TOKEN_JWT

{
  "name": "Eletrônicos",
  "description": "Produtos eletrônicos em geral"
}
```

#### 5. **Criar uma Unidade de Medida**
```http
POST /api/unit/create
Content-Type: application/json
Authorization: Bearer SEU_TOKEN_JWT

{
  "name": "Quilograma",
  "abbreviation": "kg",
  "format": "peso"
}
```

#### 6. **Criar um Produto**
```http
POST /api/product/create
Content-Type: multipart/form-data
Authorization: Bearer SEU_TOKEN_JWT

{
  "name": "Notebook Dell",
  "description": "Notebook para desenvolvimento",
  "category_id": 1,
  "unit_id": 1,
  "cost_price": 2500.00,
  "sale_price": 3500.00,
  "quantity": 10,
  "minimum_quantity": 2,
  "barcode": "123456789",
  "images": [arquivo1.jpg, arquivo2.jpg]
}
```

#### 7. **Listar Produtos com Filtros**
```http
GET /api/product/get-products-by-filter?name=Notebook&category_id=1&page=1&limit=10
Authorization: Bearer SEU_TOKEN_JWT
```

---

## 🐳 Docker

### Iniciar o Docker
```bash
docker-compose up -d
```

### Parar o Docker
```bash
docker-compose down
```

### Visualizar Logs
```bash
# Logs do banco de dados
docker-compose logs -f db

# Logs do PHP
docker-compose logs -f php

# Logs do Nginx
docker-compose logs -f nginx
```

### Acessar MySQL via CLI
```bash
docker exec -it mysql_db mysql -u root -p
# Senha: shoppassword
```

### Reiniciar Serviços
```bash
docker-compose restart
```

### Remover Contêineres e Volumes
```bash
docker-compose down -v
```

---

## 📚 Endpoints Principais

### 🔐 Autenticação
```
POST   /api/auth/login               # Login
POST   /api/user/register            # Registrar novo usuário
POST   /api/user/verify              # Verificar email
POST   /api/user/resend-verify-email # Reenviar email de verificação
```

### 📦 Produtos
```
GET    /api/product/get-products-by-filter   # Listar produtos com filtros
POST   /api/product/create                   # Criar novo produto
PUT    /api/product/{id}                     # Atualizar produto
DELETE /api/product/{id}                     # Deletar produto
```

### 👥 Usuários
```
GET    /api/user/get-users-by-filter   # Listar usuários com filtros
POST   /api/user/create                # Criar usuário
PUT    /api/user/{id}                  # Atualizar usuário
DELETE /api/user/{id}                  # Deletar usuário
```

### 📂 Categorias
```
GET    /api/category/get-categories-by-filter   # Listar categorias
POST   /api/category/create                     # Criar categoria
PUT    /api/category/{id}                       # Atualizar categoria
DELETE /api/category/{id}                       # Deletar categoria
```

### 📏 Unidades
```
GET    /api/unit/get-units-by-filter   # Listar unidades
POST   /api/unit/create                # Criar unidade
PUT    /api/unit/{id}                  # Atualizar unidade
DELETE /api/unit/{id}                  # Deletar unidade
```

### 👔 Perfis
```
GET    /api/profile/get-profiles-by-filter   # Listar perfis
POST   /api/profile/create                   # Criar perfil
PUT    /api/profile/{id}                     # Atualizar perfil
DELETE /api/profile/{id}                     # Deletar perfil
```

---

## 🧪 Testes

### Executar Todos os Testes
```bash
php artisan test
```

### Executar Testes Específicos
```bash
php artisan test --filter=NomeDoTeste
```

### Executar Testes com Coverage
```bash
php artisan test --coverage
```

### Executar Apenas Testes de Feature
```bash
php artisan test tests/Feature
```

### Executar Apenas Testes Unitários
```bash
php artisan test tests/Unit
```

---

## 🔐 Variáveis de Ambiente

```env
# Aplicação
APP_NAME="Shop API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_KEY=base64:

# Banco de Dados
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=shop_api
DB_USERNAME=root
DB_PASSWORD=shoppassword

# Autenticação Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:8000,127.0.0.1:8000
SANCTUM_EXPIRATION=525600

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

# Mail
MAIL_MAILER=log
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=debug
```

---

## 🐛 Troubleshooting

### ❌ "SQLSTATE[HY000] [2002] Connection refused"
**Problema:** Conexão com banco de dados recusada  
**Solução:**
```bash
# Restart Docker
docker-compose restart db

# Aguarde 10-15 segundos
sleep 15

# Tente conectar novamente
php artisan migrate
```

### ❌ "No such file or directory: .env"
**Problema:** Arquivo .env não existe  
**Solução:**
```bash
# Copiar arquivo de exemplo
cp .env.example .env

# Gerar chave
php artisan key:generate
```

### ❌ "Token not provided" em requisições de API
**Problema:** Header de autenticação ausente  
**Solução:**
```bash
# Adicione o header Authorization em suas requisições:
Authorization: Bearer SEU_TOKEN_JWT_AQUI
```

### ❌ "Class 'Src\...' not found"
**Problema:** Autoload do Composer não foi atualizado  
**Solução:**
```bash
composer dump-autoload
```

### ❌ Erro de permissão em storage
**Problema:** Storage não tem permissões de escrita  
**Solução (Windows):** Normalmente não há problema  
**Solução (Linux/Mac):**
```bash
chmod -R 775 storage bootstrap/cache
```

### ❌ "Composer with insufficient memory"
**Problema:** Memória insuficiente durante composer install  
**Solução:**
```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

---

## 📖 Documentação Adicional

- 🔗 [Laravel Documentation](https://laravel.com/docs)
- 🔗 [Laravel Sanctum](https://laravel.com/docs/sanctum)
- 🔗 [Vite Documentation](https://vitejs.dev/)
- 🔗 [Docker Documentation](https://docs.docker.com/)
- 🔗 [MySQL Documentation](https://dev.mysql.com/doc/)
- 🔗 [Tailwind CSS](https://tailwindcss.com/docs)

---

## 📄 Licença

Este projeto está sob a licença **MIT**. Veja o arquivo LICENSE para mais detalhes.

---

## 👨‍💻 Desenvolvido com ❤️

Construído com tecnologias modernas, Clean Architecture e melhores práticas de desenvolvimento.

**Versão:** 1.0.0  
**Última atualização:** 20 de Janeiro de 2026

---

<div align="center">

⭐ Se gostou, deixe uma star! ⭐

</div>
