<?php

namespace Modelagem\Logic;

use Firebase\JWT\JWT;
use Modelagem\DAO\PermissaoDAO;
use Modelagem\DAO\TokenDAO;
use Modelagem\DAO\UsuarioDAO;
use Modelagem\Model\Token;
use Modelagem\Model\Usuario;

class AuthLogic
{
    /** 
     * Gera token jwt e refresh token e salva no banco
     * 
     * @param int $user_id ID do usuário para gerar o token
     * 
     * @return array Array com o token jwt e refresh token
     */
    protected static function generateTokens($user_id): array
    {
        $jwt_secret_key = getenv('JWT_SECRET_KEY');
        $expire_date = strtotime('+2 days');

        $token_payload = [
            'jti' => uniqid(),
            'exp' => $expire_date,
            'sub' => $user_id,
        ];

        $refresh_token_payload = [
            'sub' => $user_id,
            'jti' => uniqid()
        ];

        $jwt = JWT::encode($token_payload, $jwt_secret_key);
        $refresh_token = JWT::encode($refresh_token_payload, $jwt_secret_key);

        $token_model = new Token();
        $token_model->jwt = $jwt;
        $token_model->refresh_token = $refresh_token;
        $token_model->id_usuario = $user_id;

        $tokenDAO = new TokenDAO();
        $tokenDAO->save($token_model);

        return array(
            'jwt' => $jwt,
            'refresh_token' => $refresh_token,
        );
    }

    protected static function formatUserData(Usuario $usuario): Usuario
    {
        $permissaoDAO = new PermissaoDAO();
        $usuario->permissoes = $permissaoDAO->listByUser($usuario->id);
        unset($usuario->senha);
        return $usuario;
    }

    /**
     * Faz login recebendo o CPF e a senha do usuário
     * 
     * @param string $cpf    CPF do usuário
     * @param string $passwd senha do usuário
     * 
     * @return array|null Retorna um array com as informações do usuário, tokens de autenticação e as permissões do usuário
     */
    public static function login(string $cpf, string $passwd): ?array
    {
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->getByCpf($cpf);

        if (!isset($usuario)) {
            return null;
        }
        if (strcmp($usuario->senha, md5((string) $passwd))) {
            return null;
        }
        $tokens = self::generateTokens($usuario->id);
        return array(
            'usuario' => (array) self::formatUserData($usuario),
            'tokens'  => $tokens
        );
    }

    /**
     * Recebe um token decodificado e retorna os dados do usuário
     * 
     * @param array $token_decoded O token de login de um usuário
     */
    public static function loginWithToken(array $token_decoded): ?Usuario
    {
        $dao = new UsuarioDAO();
        $usuario = $dao->get($token_decoded['sub']);

        if (!isset($usuario)) {
            return null;
        }
        return self::formatUserData($usuario);
    }
}
