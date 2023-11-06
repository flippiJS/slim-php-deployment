<?php

include './models/empleado.php';
include './db/empleadoSQL.php';

class EmpleadoController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['rol']) && isset($parametros['nombre']) && isset($parametros['disponible']) && isset($parametros['estado']))
        {
            $empleado = new Empleado(Rol::from($parametros['rol']), $parametros['nombre'], $parametros['disponible'], EstadoEmpleado::from($parametros['estado']));
            EmpleadoSQL::InsertarEmpleado($empleado);
            $payload = json_encode(array("mensaje" => "Empleado creado con exito."));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo crear el Empleado."));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = EmpleadoSQL::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }




}


?>