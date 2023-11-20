<?php
require_once './models/AutentificadorJWT.php';
require_once './controllers/LogController.php';

class AutenticadorController extends AutentificadorJWT
{
    public function Login($request, $response,$args)
    {
        $parametros = $request->getParsedBody();
        $usuarioBaseDeDatos=Usuario::obtenerUsuario($parametros["nombre"]);
        if($usuarioBaseDeDatos !=null)
        {
            if(password_verify($parametros["clave"],$usuarioBaseDeDatos->clave))
            {
                $datos = array('nombre' => $usuarioBaseDeDatos->nombre, "perfil"=> $usuarioBaseDeDatos->perfil);
                $token = AutentificadorJWT::CrearToken($datos);
                LogController::CargarUno($request, "Login");
                $payload = json_encode(array('mensaje' => "Usuario validado. Perfil:$usuarioBaseDeDatos->perfil",'jwt' => $token));
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