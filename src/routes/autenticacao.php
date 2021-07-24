<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Produto;
use App\Models\Usuario;
use Firebase\JWT\JWT;

//Rotas par geração de tokens
$app->post('/api/token', function (Request $request, Response $response) {
  $dados = $request->getParsedBody();
  $email = $dados['email'] ?? null;
  $senha = $dados['senha'] ?? null;

  $usuario = Usuario::where('email', $email)->first();
  
  if (!is_null($usuario) && (md5($senha) === $usuario->senha)) 
  {
    //php composer.phar require firebase/php-jwt
    $secretKey = $this->get('settings')['secretKey'];
    $jwt = JWT::encode($usuario, $secretKey);
    return $response->withJson(
    [
      'jwt' => $jwt
    ], 200);
  }

  return $response->withJson(
  [
    'status' => 'error'
  ], 401);

});