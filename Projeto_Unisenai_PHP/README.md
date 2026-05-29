# Projeto_Unisenai_PHP

## Login de usuarios (simples)

Este projeto agora possui login com tabela no banco e sessao em PHP.

### Arquivos adicionados

- auth.php
- login.php
- logout.php

### Tabela no banco

Foi adicionada a tabela `usuarios_login` no arquivo `usuarios.sql`.

Campos:

- id
- nome
- email (unico)
- senha_hash
- created_at

### Usuario inicial

- Email: admin@admin.com
- Senha: 123456

Observacao: o arquivo `login.php` tambem garante a criacao da tabela automaticamente, caso ela ainda nao exista.