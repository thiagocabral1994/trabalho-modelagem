SET NAMES 'utf8';

INSERT IGNORE INTO permissao(id, nome, descricao) VALUES
    (1, 'ADMIN_USUARIO', 'Permissão para gerenciar usuários.');

INSERT IGNORE INTO usuario (id, cpf, rg, nome, email, cep, logradouro, numero, complemento, bairro, estado, cidade, pais, telefone, senha) VALUES
    (1,'00000000001','0000001','Administrador', 'admin@ice.ufjf.br',00000001, 'rua admin',1,'202A','Bairro Laranjeiras','Minas Gerais','Juiz de Fora','Brazil','3232-3232','202cb962ac59075b964b07152d234b70');
    

INSERT IGNORE INTO grupo(id, nome, descricao) VALUES
    (1, 'Administrador', 'Grupo de administradores'),
    (2, 'Usuário', 'Grupo de usuários do sistema');

INSERT IGNORE INTO permissao_grupo(id_grupo, id_permissao) VALUES
    (1, 2),
    (1, 4),
    (1, 6),
    (1, 8),
    (1, 10),
    (1, 12),
    (1, 15),
    (1, 18),
    (1, 20),
    (2, 1);

INSERT IGNORE INTO grupo_usuario VALUES
    (1, 1); 
