<?php
require_once './models/Mesa.php';
require_once './models/Pedido.php';
require_once './controllers/UsuarioController.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $codigoMesa = $parametros['codigoMesa'];
    $estado = $parametros['estado'];
    
    $mesa = new Mesa();
    $mesa->codigoMesa = $codigoMesa;
    $mesa->estado = $estado;
    $mesa->crearMesa();

    $payload = json_encode(array("mensaje" => "Mesa creada con exito"));
    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $id = $args['id'];
    $mesa = Mesa::obtenerMesaPorId($id);

    if ($mesa) 
    {
      $payload = json_encode($mesa);
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "Mesa inexistente. Verifique los datos ingresados."));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Mesa::obtenerTodos();
    if($lista)
    {
      $payload = json_encode(array("Lista de mesas" => $lista));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No hay mesas registradas."));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }
  
  public function ModificarUno($request, $response, $args)
  {
    $datos = $request->getParsedBody();
    
    $mesaAModificar = new Mesa();
    $mesaAModificar->id=$datos["id"]; 
    $mesaAModificar->codigoMesa=$datos["codigoMesa"]; 
    $mesaAModificar->estado=$datos["estado"];
    $mesaAModificar->disponible=$datos["disponible"]; 
  
    if(Mesa::modificarMesa($mesaAModificar)) 
    {
      $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "No se pudo modificar la mesa. Intente nuevamente"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }
  
  public function BorrarUno($request, $response, $args)
  {
    $id =  $args["id"];
    if (Mesa::borrarMesa($id)) 
    {
      $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    }
    else 
    {
      $payload = json_encode(array("mensaje" => "No se pudo borrar la mesa. Intente nuevamente"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }



  
}