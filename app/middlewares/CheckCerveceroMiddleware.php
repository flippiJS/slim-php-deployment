<?php
use Dotenv\Loader\Resolver;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CheckCerveceroMiddleware{
    public function __invoke(Request $request,RequestHandler $handler) : Response
    {
       $header = $request->getHeaderLine(("Authorization"));
       $token = trim(explode("Bearer",$header)[1]);
       $response= new Response();
       try 
       {
        $data = AutentificadorJWT::ObtenerData($token);
        if($data->perfil=="cervecero")
        {
          echo "El usuario es cervecero";
          $response= $handler->handle($request);
          $response = $response->withStatus(200);
        }
        else
        {
          $response->getBody()->write(json_encode(array('Error!!' => "Esta operación solo es válida para el perfil cervecero")));
          $response = $response->withStatus(403);
        }     
      } 
      catch (Exception $e) 
      {
        $response->getBody()->write(json_encode(array('Error - Token invalido' => $e->getMessage())));
        $response = $response->withStatus(401);
      }
      return $response->withHeader('Content-Type', 'application/json');
    }
}
?>