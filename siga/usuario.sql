SELECT p.cpf, u.profile siape, p.nome, p.email, p.idpessoa id_siga, u.idusuario, u.passmd5
FROM cm_pessoa p
INNER JOIN cm_usuario u ON u.idpessoa = p.idpessoa
WHERE u.ativo = 1 AND p.idpessoa IN (642431, 791560, 27801, 666259, 1328901, 939899, 601902)
ORDER BY p.nome;
