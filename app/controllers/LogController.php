<?php
require_once './models/Log.php';
require_once './controllers/UsuarioController.php';
require_once './models/AutentificadorJWT.php';

class LogController extends Log
{
  public static function CargarUno($request, $operacion)
  {
    $header = $request->getHeaderLine('Authorization'); 
    $token = trim(explode("Bearer", $header)[1]);
    $data = AutentificadorJWT::ObtenerData($token); 
    $usuario = UsuarioController::obtenerUsuario($data->nombre);

    if($usuario)
    {
      $log = new Log();
      $log->idUsuario = $usuario->id;
      $log->operacion = $operacion;
      $log->crearLog();
    } 
    else 
    {
      echo "usuario inválido";
    }
  } 

  public function EmitirInformeOperacionesPorSector($request, $response, $args)
  {
    $listaDeOperaciones = Log::InformarOperacionesPorSector();
    $informeDeOperaciones = array();
    $cantidadDeOperaciones = 0;

    if(count($listaDeOperaciones)> 0)
    {
      foreach($listaDeOperaciones as $operacion)
      {
        $mensaje = "Sector: " . $operacion->perfil. " - Cantidad de operaciones: ". $operacion->cantidad_operaciones;
        $cantidadDeOperaciones=$cantidadDeOperaciones+$operacion->cantidad_operaciones;
        array_push($informeDeOperaciones, $mensaje);
      }

      $mensajeTotal = "Total de operaciones de todos los sectores: " . $cantidadDeOperaciones;
      array_push($informeDeOperaciones, $mensajeTotal);
      LogController::CargarUno($request, "Emitir informe de operaciones por sector");
    }
    else
    {
      $informeDeOperaciones = array("Mensaje" => "No se registraron operaciones.");
    }

    $payload = json_encode($informeDeOperaciones);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function EmitirInformeOperacionesPorEmpleadoPorSector($request, $response, $args)
  {
    $listaDeOperaciones = Log::InformarOperacionesPorEmpleadoPorSector();
    $informeDeOperaciones = array();
    $cantidadDeOperaciones = 0;

    if(count($listaDeOperaciones)> 0)
    {
      foreach($listaDeOperaciones as $operacion)
      {
        $mensaje = "Sector: " . $operacion->perfil. "- Id empleado: " . $operacion->idUsuario. "- Nombre: " . $operacion->nombre . " - Cantidad de operaciones: ". $operacion->cantidad_operaciones;
        $cantidadDeOperaciones=$cantidadDeOperaciones+$operacion->cantidad_operaciones;
        array_push($informeDeOperaciones, $mensaje);
      }

      $mensajeTotal = "Total de operaciones de todos los sectores: " . $cantidadDeOperaciones;
      array_push($informeDeOperaciones, $mensajeTotal);
      LogController::CargarUno($request, "Emitir informe de operaciones por empleados agrupados por sector");
    }
    else
    {
      $informeDeOperaciones = array("Mensaje" => "No se registraron operaciones.");
    }

    $payload = json_encode($informeDeOperaciones);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function EmitirInformeDeLoginPorEmpleado($request, $response, $args)
  {
    $idEmpleado = $args["idEmpleado"];
    $listaDeLogins = Log::InformarLoginsPorEmpleado($idEmpleado);
    $informeDeLogins = array();

    if(count($listaDeLogins)> 0)
    { 
      foreach($listaDeLogins as $login)
      {
        $mensaje = "Id empleado: " . $login->idUsuario. "- Nombre: " . $login->nombre . " - Fecha de operacion: " . $login->fecha. " - Operacion: ". $login->operacion;
        array_push($informeDeLogins, $mensaje);
      }

      LogController::CargarUno($request, "Emitir informe de logins por empleado");
    }
    else
    {
      $informeDeLogins = array("Mensaje" => "No se registraron logins para este empleado.");
    }

    $payload = json_encode($informeDeLogins);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function EmitirInformeOperacionesPorEmpleado($request, $response, $args)
  {
    $idEmpleado = $args["idEmpleado"];
    $listaDeOperaciones = Log::InformarOperacionesPorEmpleado($idEmpleado);
    $informeDeOperaciones = array();
    $cantidadDeOperaciones = count($listaDeOperaciones);

    if($cantidadDeOperaciones>0)
    {
      foreach($listaDeOperaciones as $operacion)
      {
        $mensaje = "Id empleado: " . $operacion->idUsuario. "- Nombre: " . $operacion->nombre . " - Fecha: ". $operacion->fecha . " - Operación: ". $operacion->operacion;
        array_push($informeDeOperaciones, $mensaje);
      }

      $mensajeTotal = "Total de operaciones del usuario " . $operacion->nombre  . " : " . $cantidadDeOperaciones;
      array_push($informeDeOperaciones, $mensajeTotal);
      LogController::CargarUno($request, "Emitir informe de operaciones por empleado");
    }
    else
    {
      $informeDeOperaciones = array("Mensaje" => "No se registraron operaciones para este usuario.");
    }

    $payload = json_encode($informeDeOperaciones);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

}

?>