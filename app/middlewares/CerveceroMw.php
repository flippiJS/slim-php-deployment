<?php

//use Dotenv\Loader\Resolver;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CerveceroMw
{
  public function __invoke(Request $request,RequestHandler $handler) : Response
  {
    
    $parametros = $request->getQueryParams();

    $sector = $parametros ['perfil'];

    if ($sector === 'cervecero') {
      $response = $handler->handle($request);
    }
    else {
      $response = New Response();
      $payload = json_encode(array("mensaje" => "El usuario es bartender"));
      $response->getBody()->write($payload);
    }
    
    return $response->withHeader('Content-Type', 'application/json');
  }
}
?>