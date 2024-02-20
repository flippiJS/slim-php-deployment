<?php
require_once './models/ProductoPedido.php';
require_once './controllers/LogController.php';
require_once './models/Pedido.php';

class ProductoPedidoController extends ProductoPedido
{
  public static function CargarUno($codigoPedido, $perfil, $idProducto, $cantidad, $estado)
  {        
    $productoPedido = new ProductoPedido();
    $productoPedido->codigoPedido = $codigoPedido;
    $productoPedido->perfil = $perfil;
    $productoPedido->idProducto = $idProducto;      
    $productoPedido->cantidad = $cantidad;      
    $productoPedido->estado = $estado;        
    
    $productoPedido->crearProductoPedido();
  }

  public function TraerUno($request, $response, $args)
  {
    $codigoPedido = $args['codigoPedido'];
    $pedido = Pedido::obtenerPedidoPorCodigo($codigoPedido);

    if($pedido)
    {
      $payload = json_encode($pedido);
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');           
    }
    else
    {
      $payload = json_encode(array("mensaje" => "Pedido inválido. Verifique los datos ingresados."));
      $response = $response->withStatus(400);
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Pedido::obtenerTodos();
    if($lista)
    {
      $payload = json_encode(array("Lista de productos por pedidos" => $lista));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No hay pedidos registrados."));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }      
  }
  
  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idPedido = $args["id"];
    $pedido = Pedido::obtenerPedidoPorId($idPedido);

    if($pedido)
    {
      $pedido->estado = $parametros['estado'];

      if(Pedido::modificarPedido($pedido))
      {
        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));
        $response->getBody()->write($payload);
        $response = $response->withStatus(200);
        return $response->withHeader('Content-Type', 'application/json');
      }
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No se pudo modificar el pedido. Intente nuevamente"));  
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public function BorrarUno($request, $response, $args)
  {   
    $idPedido =  $args["id"];

    if(Pedido::borrarPedido($idPedido)){
      $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No se pudo borrar el producto. Intente nuevamente."));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public function EmitirInformePendientesPorPerfil($request, $response, $args)
  {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $perfil="";
  
    switch($uri)
    {
      case "/comanda/app/ProductoPedido/InformePendientesBartender":
        $perfil="bartender";
        break;
      case "/comanda/app/ProductoPedido/InformePendientesCervecero":
        $perfil="cervecero";
        break;
      case "/comanda/app/ProductoPedido/InformePendientesCocinero":
        $perfil="cocinero";
        break;
    }

    $pedidosPendientes = ProductoPedido::InformarPendientesPorPerfil($perfil);

    /*
    echo "<br> PENDIENTES <br>";
    var_dump($pedidosPendientes);
    echo "<br>";
    */
    $cantidadPendientes = count($pedidosPendientes);
    if($cantidadPendientes > 0)
    {         
      LogController::CargarUno($request, "Emitir informe de pedidos pendientes por perfil");  
      $payload = json_encode(array($cantidadPendientes . " pedidos pendiente. Detalle: "=> $pedidosPendientes));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json'); 
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "No hay pedidos pendientes"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');   
    }
  }

  public function TomaDePedidoPorPerfil($request, $response, $args)
  {
    $uri=$_SERVER['REQUEST_URI'];
  
    switch($uri)
    {
      case "/comanda/app/ProductoPedido/TomaDePedidoBartender":
        $perfil="bartender";
        break;
      case "/comanda/app/ProductoPedido/TomaDePedidoCervecero":
        $perfil="cervecero";
        break;
      case "/comanda/app/ProductoPedido/TomaDePedidoCocinero":
        $perfil="cocinero";
        break;
    }

    $parametros = $request->getParsedBody();
    $estado = isset($parametros['estado']) ? $parametros['estado'] : null;
    $idEmpleado = isset($parametros['idEmpleado']) ? $parametros['idEmpleado'] : null;

    //echo"<br> estado: ".$estado ."<br>";
    //echo"<br> idEmpleado: ".$idEmpleado ."<br>";

    $productoPedidosPendientes = ProductoPedido::InformarPendientesPorPerfil($perfil);
    $cantidadPendientes = count($productoPedidosPendientes);

    if($cantidadPendientes > 0)
    {
      $pedidoTomado = $productoPedidosPendientes[0];

      $pedidoTomado->idEmpleado = $idEmpleado;
      $pedidoTomado->estado = $estado;
      date_default_timezone_set('America/Argentina/Buenos_Aires');
      $tiempoDeTrabajo=random_int(10, 30);
      $pedidoTomado->horarioPautado=date('Y-m-d  H:i:s', strtotime("+{$tiempoDeTrabajo} minutes"));
      ProductoPedido::TomarPedidoPorPerfil($pedidoTomado);

      PedidoController::calcularTiempoDelPedido();
      LogController::CargarUno($request, "Empezar a preparar un pedido");  
      
      $payload = json_encode(array("mensaje" => "El " . $perfil ." ha tomado el pedido"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json'); 
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "No hay pedidos pendientes"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');   
    }
  }

  public static function TerminarPedidoPorPerfil($request, $response, $args)
  {
    $uri=$_SERVER['REQUEST_URI'];
  
    switch($uri)
    {
      case "/comanda/app/ProductoPedido/TerminarPedidoBartender":
        $perfil="bartender";
        break;
      case "/comanda/app/ProductoPedido/TerminarPedidoCervecero":
        $perfil="cervecero";
        break;
      case "/comanda/app/ProductoPedido/TerminarPedidoCocinero":
        $perfil="cocinero";
        break;
    }
    $parametros = $request->getParsedBody();
    $estado = isset($parametros['estado']) ? $parametros['estado'] : null;

    $productosPedidosEnPreparacion = ProductoPedido::InformarEnPreparacionPorPerfil($perfil);
    $cantidadPendientes = count($productosPedidosEnPreparacion);
    $productoPedidoATerminar=$productosPedidosEnPreparacion[0];

    if ($cantidadPendientes > 0) 
    {
      $seccionesPedidos = ProductoPedido::obtenerSeccionPorCodigoPedido($productoPedidoATerminar->codigoPedido);
      foreach($seccionesPedidos as $seccion)
      {
        if(strcmp($seccion->estado, "en preparacion") == 0 && strcmp($seccion->perfil, $perfil) == 0)////
        {
          $seccion->estado= $estado;
          ProductoPedido::modificarProductoPedido($seccion);
          $mensajeTrabajo = "El " . $perfil . " ha terminado su trabajo.";
        }
      }
      LogController::CargarUno($request, "Terminar de preparar un pedido");  
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No hay pedidos pendientes"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');   
    } 

    if (ProductoPedidoController::VerificarEstadoProductosPorPedido($productoPedidoATerminar->codigoPedido))
    {
      $pedidoATerminar=Pedido::obtenerPedido($productoPedidoATerminar->codigoPedido);
      $pedidoATerminar->estado= "listo para servir";
      Pedido::modificarPedido($pedidoATerminar);
      $payload = json_encode(array("mensaje" => $mensajeTrabajo . " El pedido se encuentra listo para servir"));
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => $mensajeTrabajo . " Aún quedan productos del pedido por terminar"));
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public static function VerificarEstadoProductosPorPedido($codigoPedido)
  {
    $seccionesPedidos = ProductoPedido::obtenerSeccionPorCodigoPedido($codigoPedido);
    foreach($seccionesPedidos as $productoPedido)
    {
      $pedidoListoParaServir = true;
      if(strcmp($productoPedido->estado, "listo para servir")!=0)//////
      {
        $pedidoListoParaServir = false;
        break;
      }
    }

    return $pedidoListoParaServir;
  }

  public function EmitirInformeListosParaServirPorPerfil($request, $response, $args)
  {
    $uri=$_SERVER['REQUEST_URI'];
  
    switch($uri)
    {
      case "/comanda/app/ProductoPedido/InformeListosParaServirBartender":
        $perfil="bartender";
        break;
      case "/comanda/app/ProductoPedido/InformeListosParaServirCervecero":
        $perfil="cervecero";
        break;
      case "/comanda/app/ProductoPedido/InformeListosParaServirCocinero":
        $perfil="cocinero";
        break;
    }
    $pedidosListosParaServir = ProductoPedido::InformarListosParaServirPorPerfil($perfil);

    $cantidadListos = count($pedidosListosParaServir);
    if($cantidadListos > 0)
    { 
      LogController::CargarUno($request, "Emitir un listado de pedidos listos para servir");          
      $payload = json_encode(array($cantidadListos . " pedidos listos para servir. Detalle: "=> $pedidosListosParaServir));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json'); 
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "No hay pedidos listos para servir"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');   
    }
  }

  public function EmitirInformeProdOrdenadoPorCantVenta($request, $response, $args)
  {
    $pedidosConProductos = ProductoPedido::InformarProdOrdenadoPorCantVenta();
    $cantidadDePedidos = count($pedidosConProductos);
    $listaProdVendidos = array();

    if($cantidadDePedidos>0)
    {    
      foreach($pedidosConProductos as $pedidoConProd)
      { 
        $mensaje = "Id del producto: " . $pedidoConProd->idProducto. " - Nombre del producto: " . $pedidoConProd->nombre. " - Cantidad vendida: " . $pedidoConProd->cantidad_vendida;
        array_push($listaProdVendidos, $mensaje);
      }

      LogController::CargarUno($request, "Emitir listado de productos por cantidad vendida");  
      $payload = json_encode($listaProdVendidos);
      $response = $response->withStatus(200); 
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No hubieron ventas."));
      $response = $response->withStatus(400);
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }
}

?>