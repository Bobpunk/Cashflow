# 💰 CashFlow — Gerenciador Financeiro

> Sistema web de controle financeiro pessoal desenvolvido com **PHP Puro (sem frameworks)**.

O **CashFlow** é uma aplicação web para gerenciamento de **receitas e despesas**, criada com o objetivo de consolidar os fundamentos do desenvolvimento web backend.  
Todo o sistema foi construído **“na unha”**, sem frameworks, com foco em **segurança, organização e boas práticas**.

---

## 📌 Visão Geral

- 📈 Controle financeiro pessoal
- 🧠 Backend em PHP puro
- 🔐 Foco em segurança e boas práticas
- 🧱 Estrutura simples, clara e bem organizada

---

## 📸 Screenshots

> *(Adicione aqui imagens do sistema: Login, Dashboard e Cadastro de Movimentações)*

---

## 🚀 Funcionalidades

### 🔐 Autenticação
- Sistema de **Login e Logout**
- Senhas criptografadas com `password_hash()`

### 🧾 Movimentações Financeiras
- **CRUD completo**:
  - Criar
  - Listar
  - Editar
  - Excluir receitas e despesas

### 📊 Dashboard
- Cálculo automático de:
  - Saldo atual
  - Total de receitas
  - Total de despesas

### 📅 Filtros
- Visualização de movimentações por **Mês / Ano**

### 🛡️ Segurança
- Proteção contra **SQL Injection** (PDO + Prepared Statements)
- Proteção contra **XSS** (sanitização de saídas HTML)
- Controle de sessões e **rotas protegidas**

---

## 🛠️ Tecnologias Utilizadas

### 💻 Back-end
- PHP 8+
- PDO
- Sessions
- Manipulação de Datas

### 🗄️ Banco de Dados
- MariaDB / MySQL

### 🎨 Front-end
- HTML5
- CSS3 (layout responsivo e organizado)

---

## 🧪 Ambiente de Desenvolvimento

- **Sistema Operacional:** Puppy Linux (TrixiePup Wayland) — `puppypc7008`
- **Kernel:** Linux 6.12.57
- **Servidor:** Servidor embutido do PHP

---

## ⚙️ Como Executar o Projeto Localmente

###  Clonar o Repositório

```
git clone https://github.com/Bobpunk/Cashflow
cd cashflow-php-native
```
# ⚙️ Configuração do Projeto

### Configurar o Banco de Dados

Crie o banco de dados `cashflow` e execute o SQL abaixo:

```sql
CREATE DATABASE cashflow;
USE cashflow;

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255)
);

-- Tabela de movimentações
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    tipo ENUM('receita', 'despesa') NOT NULL,
    data DATE DEFAULT CURRENT_DATE
);
`````

### Configurar a Conexão com o Banco de Dados

Crie um arquivo chamado database.ini na raiz do projeto e adicione suas credenciais:

``` 
host = localhost
dbname = cashflow
user = root
password = "SUA_SENHA_DO_BANCO"

```

### Iniciar o Servidor

Execute o comando abaixo no diretório do projeto:
```
php -S localhost:8000
```

Acesse no navegador:
```
http://localhost:8000

```

## 📚 Aprendizados

Projeto desenvolvido como **conclusão do Módulo 1 — Fundamentos Web & PHP**.

### Principais conceitos aplicados

- Manipulação de banco de dados com **PDO**
- Autenticação e gerenciamento de **Sessões HTTP**
- Estruturação e **refatoração de código**
- Boas práticas de **segurança web**
- Versionamento com **Git e GitHub**

---

## 📞 Autor

Desenvolvido por **J.C. Fonseca Junior**

🔗 **LinkedIn:**  
https://www.linkedin.com/in/jcfonsecajunior/
