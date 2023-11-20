<?php
require_once './models/Pedido.php';
require_once './models/Producto.php';
require_once './models/Mesa.php';
require_once './controllers/MesaController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/ProductoPedidoController.php';
require_once './controllers/LogController.php';
require_once './interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    
    $idMesa = $parametros['idMesa'];
    $codigoPedido = $parametros['codigoPedido'];
    $idMozo = $parametros['idMozo'];
    $nombreCliente = $parametros['nombreCliente'];
    $productos = $parametros['productos'];  
    $estado = $parametros['estado'];     
    
    $pedido = new Pedido();   
    $pedido->idMesa = $idMesa; 
    $pedido->codigoPedido = $codigoPedido; 
    $pedido->idMozo = $idMozo; 
    $pedido->nombreCliente = $nombreCliente;   
    if(file_exists($_FILES["fotoMesa"]["tmp_name"]))
    {
      $pedido->fotoMesa = $this->tomarFoto();
    } 
    else 
    {
      $pedido->fotoMesa = null;
    }
    $pedido->estado = $estado;  

    $productos = json_decode($productos);
    foreach($productos as $producto)
    {  
      $productoComprado = Producto::obtenerProductoPorNombre($producto->producto);
      if($productoComprado)
      {
        MesaController::actualizarEstadoMesa("con cliente esperando pedido", $idMesa);
        ProductoPedidoController::CargarUno($codigoPedido,$productoComprado->sector, $productoComprado->id, $producto->cantidad, "Pendiente");
      }
    }
    $pedido->crearPedido();
    LogController::CargarUno($request, "Alta de un pedido");   

    $payload = json_encode(array("mensaje" => "Pedido creado con exito. El código de su pedido es: " 
    . $pedido->codigoPedido . ". Con él podrá verificar el estado de su pedido"));  
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    $id = $args['id'];
    $pedido = Pedido::obtenerPedidoPorId($id);

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
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Pedido::obtenerTodos();
    if($lista)
    {
      $payload = json_encode(array("Lista de pedidos" => $lista));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "No hay pedidos."));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }
    
  public function ModificarUno($request, $response, $args)
  {
    $datos = json_decode(file_get_contents("php://input"), true);
    $pedido = new Pedido();
    $pedido->id=$datos["id"]; 
    $pedido->idMesa=$datos["idMesa"]; 
    $pedido->codigoPedido=$datos["codigoPedido"]; 
    $pedido->idMozo=$datos["idMozo"]; 
    $pedido->nombreCliente=$datos["nombreCliente"];
    $pedido->fotoMesa=$datos["fotoMesa"]; 
    $pedido->horarioPautado=$datos["horarioPautado"];
    $pedido->estado=$datos["estado"]; 

    if(Pedido::modificarPedido($pedido))
    {
      $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No se pudo modificar el pedido. Verifique los datos ingresados."));  
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public function BorrarUno($request, $response, $args)
  {   
    $id =  $args["id"];
    $pedidoABorrar=Pedido::obtenerPedidoPorId($id);
    if(Pedido::borrarPedido($id))
    {
      ProductoPedido::borrarProductoPedidoPorCodigo($pedidoABorrar->codigoPedido);
      $payload = json_encode(array("mensaje" => "Pedido cancelado con exito"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json');
    }
    else
    {
      $payload = json_encode(array("mensaje" => "No se pudo cancelar el pedido. Verifique los datos ingresados."));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');
    }
  }

  public static function tomarFoto()
  {
    $carpetaFotos = ".".DIRECTORY_SEPARATOR."fotosMesas".DIRECTORY_SEPARATOR;
    if(!file_exists($carpetaFotos))
    {
        mkdir($carpetaFotos, 0777, true);
    }
    $nuevoNombre = $carpetaFotos.$_FILES["fotoMesa"]["name"];
    rename($_FILES["fotoMesa"]["tmp_name"], $nuevoNombre);

    return $nuevoNombre;
  }

  public static function tomarFotoPosterior($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    
    $idPedido= $parametros["idPedido"];
    $pedidoAModificar=Pedido::obtenerPedidoPorId($idPedido);
    if($pedidoAModificar->fotoMesa == null)
    {
      $pedidoAModificar->fotoMesa = PedidoController::tomarFoto();
      if (Pedido::asignarFotoPosterior($pedidoAModificar)) 
      {
        $payload = json_encode(array("mensaje" => "Foto asignada al pedido con exito"));
        $response = $response->withStatus(200);
      } 
      else 
      {
        LogController::CargarUno($request, "Asignar una foto al pedido");
        $payload = json_encode(array("mensaje" => "No se pudo asignar una foto al pedido"));
        $response = $response->withStatus(400);
      }
    }
    else
    {
      $payload = json_encode(array("mensaje" => "El pedido ya posee una foto asignada."));  
      $response = $response->withStatus(400);
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public static function calcularTiempoDelPedido()
  {
    $listaDePedidos = Pedido::obtenerTodos();
    if($listaDePedidos)
    {
      foreach($listaDePedidos as $pedido)
      {
        $seccionesComanda = ProductoPedidoController::obtenerSeccionPorCodigoPedido($pedido->codigoPedido);
        $maximoTiempoPedido = 0;
        $todosTiemposDeterminados=true;
        foreach($seccionesComanda as $seccion)
        {
          if($seccion->horarioPautado !=null )
          {
            if($seccion->horarioPautado > $maximoTiempoPedido)
            {
              $maximoTiempoPedido = $seccion->horarioPautado;
            }
          }
          else
          {
            $todosTiemposDeterminados=false;
            break;
          }
        }

        if($todosTiemposDeterminados && $pedido->estado == "pendiente")
        {
          $pedido->estado = "en preparacion";
          $pedido->horarioPautado = $maximoTiempoPedido;
          Pedido::modificarPedido($pedido);
        }
      }
    }
  }

  public function EmitirInformeTiempoDeDemoraPedido($request, $response, $args)
  {
    PedidoController::calcularTiempoDelPedido();
    
    $codigoMesa = $request->getQueryParams()["codigoMesa"];
    $codigoPedido = $request->getQueryParams()["codigoPedido"];
    
    $mesa = Mesa::obtenerMesaPorCodigo($codigoMesa);
    $pedido = PedidoController::obtenerPedidoPorCodigo($codigoPedido);

    if($mesa && $pedido)
    {
      date_default_timezone_set("America/Argentina/Buenos_Aires");
      $horarioActual = new DateTime("now");
      $horarioPedido = datetime::createfromformat('Y-m-d H:i:s', $pedido->horarioPautado);
      if($pedido->horarioPautado != null)
      {
        if($horarioPedido < $horarioActual)
        {
          $payload = json_encode(array("mensaje" => "Su pedido ya ha sido terminado. Será servido a la brevedad")); 
        }
        else
        {
          $diferenciaEnMinutos = $horarioActual->diff($horarioPedido);
          $minutosRestantes = $diferenciaEnMinutos->days * 24 * 60;
          $minutosRestantes += $diferenciaEnMinutos->h * 60;
          $minutosRestantes += $diferenciaEnMinutos->i; 
          $payload = json_encode(array("mensaje" => "Su pedido será servido en: " . $minutosRestantes . " minutos"));
          $response = $response->withStatus(200);             
        }
      } 
      else 
      {
        $payload = json_encode(array("mensaje" => "Algun producto de su pedido aún no ha comenzado a prepararse.")); 
      }
    }
    else
    {
      $payload = json_encode(array("mensaje" => "Código de mesa o pedido inválido. Verifique los datos ingresados.")); 
      $response = $response->withStatus(400); 
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function EmitirInformeListosParaServirTodos($request, $response, $args)
  {
    $pedidosListosTodos = Pedido::InformarListosParaServirTodos();

    $cantidadListos = count($pedidosListosTodos);
    if($cantidadListos > 0)
    {     
      LogController::CargarUno($request, "Emitir informe de pedidos listos para servir");     
      $payload = json_encode(array($cantidadListos . " pedidos listos para servir. Detalle: "=> $pedidosListosTodos));
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

  public function EmitirInformeMesaMasUsada($request, $response, $args)
  {  
    $mesaMasUsada = Pedido::InformarMesaMasUsada();
    if($mesaMasUsada)
    {
      LogController::CargarUno($request, "Emitir informe de mesa más usada");  
      $payload = json_encode(array("La mesa más usada es: " => $mesaMasUsada));
      $response = $response->withStatus(200);
    }
    else
    {
      $payload = json_encode(array("No hay mesas abiertas"));
      $response = $response->withStatus(400);
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');    
  }

  public function EmitirInformePedidosNoATiempo($request, $response, $args)
  {  
    $pedidos = Pedido::InformarPedidosNoATiempo();
    $cantidadDePedidos = count($pedidos);
    $listadoDePedidosNoAtiempo = array();

    if($cantidadDePedidos>0)
    {    
      foreach($pedidos as $pedido)
      {
        $horarioPedido = datetime::createfromformat('Y-m-d H:i:s', $pedido->horarioPautado);
        $horarioEntregado = datetime::createfromformat('Y-m-d H:i:s', $pedido->horarioEntregado);
        $diferenciaEnMinutos = $horarioEntregado->diff($horarioPedido);
        $minutosDeDemora = $diferenciaEnMinutos->days * 24 * 60;
        $minutosDeDemora += $diferenciaEnMinutos->h * 60;
        $minutosDeDemora += $diferenciaEnMinutos->i;   

        $mensaje = "Pedido: " . $pedido->codigoPedido. " Horario pautado: " . $pedido->horarioPautado . " Horario entregado: " . $pedido->horarioEntregado. " Minutos de demora: " . $minutosDeDemora;
        array_push($listadoDePedidosNoAtiempo, $mensaje);
        $response = $response->withStatus(200);
        LogController::CargarUno($request, "Emitir informe de pedidos no entregados a tiempo");  
      }
    }
    else
    {
      $listadoDePedidosNoAtiempo = array("Mensaje" => "No hay pedidos."); 
      $response = $response->withStatus(400);
    }

    $payload = json_encode($listadoDePedidosNoAtiempo);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function EmitirInformeMesasPorFacturacion($request, $response, $args)
  {  
    $pedidos = Pedido::InformarMesasOrdenadasPorFacturacion();
    $cantidadDePedidos = count($pedidos);
    $listadoDePedidosNoAtiempo = array();

    if($cantidadDePedidos>0)
    {    
      foreach($pedidos as $pedido)
      {
        $mensaje = "Id Mesa: " . $pedido->idMesa. " Código de mesa: " . $pedido->codigoMesa .
        " Código de pedido: " . $pedido->codigoPedido . " Total Facturado: " . $pedido->totalFacturado;
        array_push($listadoDePedidosNoAtiempo, $mensaje);
      }
      $response = $response->withStatus(200);
      LogController::CargarUno($request, "Emitir informes de mesas por monto de facturación");  
    }
    else
    {
      $listadoDePedidosNoAtiempo = array("Mensaje" => "No hay mesas a informar."); 
      $response = $response->withStatus(400);
    }

    $payload = json_encode($listadoDePedidosNoAtiempo);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function EmitirInformeFacturadoEntreFechas($request, $response, $args)
  {  
    $idMesa = $request->getQueryParams()["idMesa"];
    $fechaDesde = $request->getQueryParams()["fechaDesde"];
    $fechaHasta = $request->getQueryParams()["fechaHasta"];

    $pedido = Pedido::InformarFacturadoEntreFechasPorMesa($idMesa,$fechaDesde, $fechaHasta);

    if($pedido)
    { 
      LogController::CargarUno($request, "Informe de lo facturado por mesa entre determinadas fechas");     
      $mensaje = "Mesa con mayor facturación => Id mesa: " . $pedido->idMesa. " Facturación total desde el " . $fechaDesde . " al " . $fechaHasta . " : $" . $pedido->facturacion_total;
      $payload = json_encode($mensaje);
      $response = $response->withStatus(200);
    }
    else
    {
      $response = $response->withStatus(400);
      $payload = json_encode(array("Mensaje" => "La mesa no registró facturación en el período consultado."));
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function EmitirInformePedidosCancelados($request, $response, $args)
  {
    $pedidosCancelados = Pedido::InformarPedidosCancelados();

    $cantidadPedidosCancelados = count($pedidosCancelados);
    if($cantidadPedidosCancelados > 0)
    {     
      LogController::CargarUno($request, "Emitir informe de pedidos cancelados");     
      $payload = json_encode(array($cantidadPedidosCancelados . " pedidos cancelados. Detalle: "=> $pedidosCancelados));
      $response->getBody()->write($payload);
      $response = $response->withStatus(200);
      return $response->withHeader('Content-Type', 'application/json'); 
    } 
    else 
    {
      $payload = json_encode(array("mensaje" => "No hay pedidos pedidos cancelados"));
      $response->getBody()->write($payload);
      $response = $response->withStatus(400);
      return $response->withHeader('Content-Type', 'application/json');   
    }
  }

  public function EmitirInformeMesaMenosUsada($request, $response, $args)
  {  
    $mesaMenosUsada = Pedido::InformarMesaMenosUsada();
    if($mesaMenosUsada)
    {
      LogController::CargarUno($request, "Emitir informe de mesa menos usada");  
      $payload = json_encode(array("La mesa menos usada es: " => $mesaMenosUsada));
      $response = $response->withStatus(200);
    }
    else
    {
      $payload = json_encode(array("No hay mesas abiertas"));
      $response = $response->withStatus(400);
    }

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');    
  }

  public function EmitirInformeMesasFacturacionAcumulada($request, $response, $args)
  {  
    $uri=$_SERVER['REQUEST_URI'];
    $mesaAInformar = array();

    $criterio="";
    $opcion="";

    switch($uri)
    {
      case "/pedidos/InformeMesasMayorFacturacion":
        $criterio="DESC";
        $opcion="mayor";
        break;
      case "/pedidos/InformeMesasMenorFacturacion":
        $criterio="ASC";
        $opcion="menor";
        break;
    }

    $mesa = Pedido::InformarFacturacionAcumuladaMesas($criterio);

    if($mesa)
    {
      $mesaAInformar = array("Mesa con mayor facturación => Id mesa: " . $mesa->idMesa . " Código mesa: " 
      . $mesa->codigoMesa . " Facturación total acumulada " . $mesa->facturacion_total);    
      $response = $response->withStatus(200);
      LogController::CargarUno($request, "Emitir informes de mesas de" . $opcion ."facturación");  
    }
    else
    {
      $mesaAInformar = array("Mensaje" => "No hay pedidos registrados."); 
      $response = $response->withStatus(400);
    }

    $payload = json_encode($mesaAInformar);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }
}

?>