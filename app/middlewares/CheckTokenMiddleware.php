<?php
use Dotenv\Loader\Resolver;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

require_once './controllers/LogController.php';

class CheckTokenMiddleware{
    public function __invoke(Request $request,RequestHandler $handler) : Response
    {
      $header = $request->getHeaderLine(("Authorization"));

      $response= new Response();

      $tokenArray = explode("Bearer", $header);
      if (count($tokenArray) < 2) 
      {
          // El encabezado Authorization no contiene un token válido
          $response->getBody()->write(json_encode(array('error - Token invalido' => 'El encabezado Authorization esta vacio.')));
          return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
      }

      $token = trim(explode("Bearer",$header)[1]);
      $response= new Response();
      try 
      {
        json_encode(array('datos' => AutentificadorJWT::VerificarToken($token)));
        //echo "Token validado";
        $response= $handler->handle($request);
        $response = $response->withStatus(200);
      } 
      catch (Exception $e) 
      {
        $response->getBody()->write(json_encode(array('error - Token invalido' => $e->getMessage())));
        $response = $response->withStatus(401);
      }
      return $response->withHeader('Content-Type', 'application/json');
    }
}
?>