# Comunicado Interno e Banco de Horas
---

# Configuração:
Após clonar o git: 
    
    Executar composer install
    Alterar o .env.example para .env
    Executar php artisan key:generate
    Configurar .env
    Executar php artisan migrate


Para o primeiro acesso é necessária a criação de um usuário administrador direto no banco de dados.

```sh
INSERT INTO users (name,username,admin,password,created_at,updated_at) 
VALUES ('Admin','administrador',1,'$2y$10$KKmsEkwJp8Zy4Xj8E2b8t.WbszF0C7UyLhTuFBL/pLns9jaQuwEjC','2021/02/11 00:00:00','2021/02/11 00:00:00')
```

## Conta de Administrador
Usuário: administrador\
Senha: 123321\
`Após o primeiro acesso, não se esqueça de alterar a conta padrão.`

Niveis de acesso ao sistema:

| Valor | Nome | Descrição
| ------ | ------ | ------ |
| 1 | Administrador do Sistema  | Controle total dos usuários, funcionários, comunicados e banco de horas.
| 2 | Administrador Geral | Visualização de todos os comunicados criados e Controle de contabilização do banco de horas.
| 3 | Chefe de Setor | Visualização dos comunicados criados e enviados do seu setor, criação de banco de horas ou compensada para funcionarios de seu setor.

