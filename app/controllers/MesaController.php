<?php
require_once './models/Mesa.php';
require_once './models/Pedido.php';
require_once './models/ProductoPedido.php';
require_once './controllers/UsuarioController.php';
require_once './interfaces/IApiUsable.php';
require_once './controllers/LogController.php';

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

  public function EmitirInformeDeEstadoDeMesas($request, $response, $args)
  {
    $listadoDeMesas= Mesa::InformarEstadosDeMesas();
    $cantidadDeMesas = count($listadoDeMesas);

    if($cantidadDeMesas>0)
    {
      LogController::CargarUno($request, "Emisión de informe de estado de las mesas");
      $payload = json_encode(array("Cantidad de mesas: " . $cantidadDeMesas . ". Detalle: "=> $listadoDeMesas));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json'); 
    }
    else 
    {        
      $payload = json_encode(array("mensaje" => "No hay mesas abiertas"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json'); 
    }
  }

  public function ServirMesa($request, $response, $args)
  {
    $datos = $request->getParsedBody();
    $idMesa=$datos["idMesa"]; 
    $estado=$datos["estado"];

    $pedido = Pedido::obtenerPedidoPorIdMesaYEstado($idMesa);
    $seccionPedido = ProductoPedido::obtenerSeccionPorCodigoPedido($pedido->codigoPedido);

    if($pedido && $seccionPedido)
    {
      Mesa::actualizarEstadoMesa($estado, $idMesa);
      foreach ($seccionPedido as $seccion) 
      {
        $seccion->estado = "entregado";
        ProductoPedido::modificarProductoPedido($seccion);
      }
      
      $pedido->estado = "entregado";
      date_default_timezone_set("America/Argentina/Buenos_Aires");
      $pedido->horarioEntregado = date('Y-m-d  H:i:s');
      Pedido::modificarPedido($pedido);
      LogController::CargarUno($request, "Servir la mesa");

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

  public function CobrarMesa($request, $response, $args)
  {
    $id = $args["id"];
    $mesa = Mesa::obtenerMesaPorId($id);  
    $pedido = Pedido::obtenerPedidoPorIdMesaYEntregado($id);

    if($mesa && $pedido) 
    {
      if (strcmp($mesa->estado, "con cliente comiendo") == 0) 
      {
        $mesa->estado = "con cliente pagando";
        Mesa::modificarMesa($mesa);
        $totalCobrado = 0;
        $productoPedido = ProductoPedido::obtenerSeccionPorCodigoPedido($pedido->codigoPedido);
        
        if($productoPedido)
        {
          foreach ($productoPedido as $seccionPedido) {
            $producto = Producto::obtenerProductoPorId($seccionPedido->idProducto);
            $totalCobrado = $totalCobrado + ($seccionPedido->cantidad * $producto->precio);
          }

          $pedido->totalFacturado = $totalCobrado;
          Pedido::modificarPedido($pedido);
          LogController::CargarUno($request, "Cobrar la cuenta de la mesa");  
          
          $payload = json_encode(array("mensaje" => "El total cobrado es $". $totalCobrado));
          $response = $response->withStatus(200);
        } 
      }
      else 
      {
        $payload = json_encode(array("mensaje" => "La mesa no está pendiente de cobro. Verifique los datos ingresados"));
        $response = $response->withStatus(400);
      }
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "Mesa inexistente. Verifique los datos ingresados"));
      $response = $response->withStatus(400);
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  
  public function CerrarMesa($request, $response, $args)
  {
    $id = $args["id"];
    $mesa = Mesa::obtenerMesaPorId($id);
  
    if ($mesa) 
    {
      if (strcmp($mesa->estado, "con cliente pagando") == 0) 
      {
        $mesa->estado = "cerrada";
        if (Mesa::modificarMesa($mesa)) 
        {
          LogController::CargarUno($request, "Cierre de mesa");  
          $payload = json_encode(array("mensaje" => "Mesa cerrada con exito"));
          $response = $response->withStatus(200);
        } 
        else
        {
          $payload = json_encode(array("mensaje" => "No se pudo cerrar la mesa. Intente nuevamente."));
          $response = $response->withStatus(400);
        }
      } 
      else 
      {
        $payload = json_encode(array("mensaje" => "La mesa no está con cliente pagando. Intente nuevamente."));
        $response = $response->withStatus(400);
      }
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "Mesa inexistente. Verifique los datos ingresados."));
      $response = $response->withStatus(400);
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }
  
}

?>