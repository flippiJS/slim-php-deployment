<?php
require_once './models/Usuario.php';
require_once './models/AutentificadorJWT.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $nombre = $parametros['nombre'];
    $clave = $parametros['clave'];
    $perfil = $parametros["perfil"];
    $fechaAlta = $parametros["fechaAlta"];

    $usr = new Usuario();
    $usr->nombre = $nombre;
    $usr->clave = $clave;
    $usr->perfil= $perfil;
    $usr->fechaAlta= $fechaAlta;
    $usr->crearUsuario();

    $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    return $response->withHeader('Content-Type', 'application/json');
  }
    
  public function TraerUno($request, $response, $args)
  {
    $id = $args['id'];
    $usuario = Usuario::obtenerUsuarioPorId($id);

    if($usuario)
    {
      $payload = json_encode($usuario);
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');           
    }
    else
    {
      $payload = json_encode(array("mensaje" => "Usuario inválido. Verifique los datos ingresados."));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public static function obtenerUsuario($nombre)
  {
    $usuario = Usuario::obtenerUsuario($nombre);
    if($usuario)
    {
      return $usuario;
    }
  }
  
  public function TraerTodos($request, $response, $args)
  {
    $lista = Usuario::obtenerTodos();
    $payload = json_encode(array("listaUsuarios" => $lista));
    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $datos = json_decode(file_get_contents("php://input"), true);
    $usuarioAModificar = new Usuario();
    $usuarioAModificar->id=$datos["id"]; 
    $usuarioAModificar->nombre=$datos["nombre"]; 
    $usuarioAModificar->clave=$datos["clave"]; 
    $usuarioAModificar->perfil=$datos["perfil"];
    $usuarioAModificar->fechaAlta=$datos["fechaAlta"]; 
    if(array_key_exists("fechaAlta",$datos))
    {
      $usuarioAModificar->fechaAlta=$datos["fechaAlta"]; 
    }
    if(array_key_exists("fechaBaja",$datos))
    {
      $usuarioAModificar->fechaBaja=$datos["fechaBaja"]; 
    }

    if (Usuario::modificarUsuario($usuarioAModificar)) 
    {        
      $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    } 
    else
    {
      $payload = json_encode(array("mensaje" => "No se pudo modificar el usuario. Intente nuevamente"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public function BorrarUno($request, $response, $args)
  {
    $datos = json_decode(file_get_contents("php://input"), true);
    $id=$datos["id"]; 
    Usuario::borrarUsuario($id);

    $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    return $response->withHeader('Content-Type', 'application/json');
  }

  
}
?>