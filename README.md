# Fortnite Hub

Portal em PHP para acompanhar informações do Fortnite com foco em loja, cosméticos, notícias, mapa, modos e busca de jogador.

Projeto de portfólio com arquitetura MVC artesanal (sem framework pesado), refinado para execução em ambientes locais e Docker.

## Visão Geral

O Fortnite Hub foi construído para demonstrar:

- organização de código em MVC manual
- consumo de API externa com cache
- roteamento próprio
- renderização server-side com PHP
- base visual moderna com identidade gamer
- cobertura unitária inicial com PHPUnit

## Stack Real

- PHP 8.1+
- HTML + CSS + JavaScript
- MVC artesanal
- Composer (autoload + scripts)
- PHPUnit
- Bootstrap 4.5 (layout/base components)
- Docker + Apache (opcional)

## Funcionalidades Implementadas

- Home com destaques da loja
- Loja diária com busca por texto
- Catálogo de cosméticos com carregamento incremental
- Detalhes de cosmético por ID
- Notícias gerais, BR e STW
- Mapa atual com alternância de visualização (com/sem POIs)
- Página de modos de jogo (catálogo curado local)
- Busca de estatísticas de jogador por plataforma
- Páginas de erro 404/500 customizadas
- Cache local em arquivo para respostas da API
- Manifest + Service Worker para comportamento PWA básico

## Arquitetura Atual

### Fluxo principal

1. Requisição entra por public/index.php
2. bootstrap/app.php inicializa ambiente, config, headers e router
3. config/routes.php registra rotas
4. Router resolve controller/método
5. Controller usa Model/Service para montar view model
6. View é renderizada no layout principal

### Camadas

- app/Core: base de infraestrutura (Config, Env, Router, Controller, Cache, HTTP)
- app/Services: clientes de integração externa
- app/Models: interface legada/compatível para consumo pelos controllers
- app/Controllers: orquestração da requisição
- app/Views: templates por feature
- config/routes.php: definição central de rotas
- bootstrap/app.php: inicialização da aplicação

## Estrutura de Pastas

```text
Fortnite/
├── app/
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   ├── Services/
│   └── Views/
├── bootstrap/
│   └── app.php
├── config/
│   └── routes.php
├── public/
│   ├── index.php
│   ├── autoload.php
│   ├── css/
│   ├── img/
│   ├── manifest.json
│   └── sw.js
├── tests/
│   ├── Support/
│   └── Unit/
├── docker/
├── cache/
├── composer.json
├── docker-compose.yml
└── phpunit.xml
```

## Configuração de Ambiente

Crie seu arquivo .env a partir do exemplo:

```bash
cp .env.example .env
```

Variáveis principais:

- FORTNITE_API_KEY: chave da API
- FORTNITE_API_URL: URL base da API Fortnite
- APP_ENV: development|production
- APP_DEBUG: true|false
- APP_STRICT_CONFIG: true|false, falha cedo em produção quando variáveis críticas faltarem
- APP_BASE_URL: opcional, sobrescreve autodetecção de base URL
- CACHE_ENABLED: habilita/desabilita cache local
- CACHE_TTL: TTL padrão do cache (segundos)

## Como Rodar Localmente

### Opção 1: PHP built-in server

```bash
composer install
composer start
```

Acesse: [http://localhost:8000](http://localhost:8000)

### Opção 2: XAMPP/Apache

- configure o DocumentRoot para a pasta public
- ou mantenha a raiz do projeto e use os arquivos de rewrite incluídos

Exemplo comum:

- projeto em C:/xampp/htdocs/Fortnite
- acesso via [http://localhost/Fortnite/public](http://localhost/Fortnite/public)

### Opção 3: Docker

```bash
docker-compose up -d
```

Acesse: [http://localhost:8080](http://localhost:8080)

## Testes e Qualidade

Executar testes:

```bash
composer test
```

Cobertura HTML:

```bash
composer test:coverage
```

Lint de estilo:

```bash
composer lint
```

Observações:

- os testes existentes cobrem Router, Cache e contrato básico da camada de API
- testes de integração real com API externa não estão completos nesta versão

## Segurança e Robustez (implementado)

- sanitização de saída nas views com htmlspecialchars
- headers básicos enviados no bootstrap (nosniff, frame options, referrer policy, permissions policy)
- validação básica de parâmetros críticos (ex.: ID de cosmético, plataforma)
- tratamento de erro com fallback 404/500
- distinção de falhas na comunicação externa (rede/http/payload/API)

## PWA, CI/CD e Deploy: Estado Real

### PWA

- implementado: manifest, service worker e cache básico de assets
- não implementado: estratégia offline completa para dados dinâmicos

### CI

- workflow de CI presente em .github/workflows/ci.yml
- inclui lint, testes e etapas de build/security
- uso efetivo depende da configuração de secrets do repositório

### Deploy

- não há pipeline de deploy produtivo pronto para uso imediato
- existe base para evolução no workflow

## APIs Utilizadas

- Fortnite-API.com
  - loja, cosméticos, notícias e estatísticas
- FortniteAPI.io (imagem de mapa)
  - render de mapa atual via URL de mídia

## Limitações Atuais

- página de modos usa catálogo local curado (não totalmente API-driven)
- mapa usa imagem externa (sem engine de mapa interativo própria)
- parte dos estados avançados de UX ainda pode evoluir (ex.: skeletons em todas as telas)
- cobertura de testes ainda é enxuta para regras de negócio mais profundas

## Roadmap

- aumentar cobertura de testes para controllers e fluxo de erro de views
- evoluir componente de estados reutilizáveis (loading/empty/error) para todas as páginas
- melhorar filtros e paginação na loja
- ampliar observabilidade (logs estruturados)
- maturar estratégia de deploy contínuo

## Repositório

```bash
git clone https://github.com/AndersonCav/Fortnite.git
```

## Nota Legal

Este projeto não é afiliado à Epic Games. Fortnite é marca registrada de seus respectivos proprietários.

Dados consumidos de provedores públicos de API de terceiros.
