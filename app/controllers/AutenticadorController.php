<?php
require_once './models/AutentificadorJWT.php';
require_once './controllers/LogController.php';

class AutenticadorController extends AutentificadorJWT
{
    public function CrearTokenLogin($request, $response,$args)
    {
        $parametros = $request->getParsedBody();
        $usuarioBaseDeDatos=Usuario::obtenerUsuario($parametros["nombre"]);
        echo $usuarioBaseDeDatos->nombre. "<br>";
        echo $usuarioBaseDeDatos->clave. "<br>";

        echo "clave parametros: ".$parametros["clave"]. "<br>";

        if($usuarioBaseDeDatos != null)
        {       
            if($parametros["clave"] == $usuarioBaseDeDatos->clave)
            {
                $datos = array('nombre' => $usuarioBaseDeDatos->nombre, "perfil"=> $usuarioBaseDeDatos->perfil);
                $token = AutentificadorJWT::CrearToken($datos);
                LogController::CargarLogin($usuarioBaseDeDatos, "Login");
                //$payload = json_encode(array('mensaje' => "Usuario validado. Perfil:$usuarioBaseDeDatos->perfil",'jwt' => $token));
                $payload = json_encode(array('jwt' => $token));
                $response->getBody()->write($payload);
                $response = $response->withStatus(200);
            }
            else
            {
                $response->getBody()->write("Error en los datos ingresados");
                $response = $response->withStatus(403);
            }
        }
        else
        {
            $response->getBody()->write("El usuario no existe");
            $response = $response->withStatus(403);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}
?>