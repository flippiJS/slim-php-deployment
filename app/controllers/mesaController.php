<?php

include './models/mesa.php';


class MesaController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['idPedido']) && isset($parametros['idMozo']) && isset($parametros['estado']) && self::ValidarEstado($parametros['estado']))
        {
            $mesa = new Mesa();
            $mesa->idPedido = $parametros['idPedido'];
            $mesa->idMozo = $parametros['idMozo'];
            $mesa->estado = $parametros['estado'];
            Mesa::InsertarMesa($mesa);
            $payload = json_encode(array("mensaje" => "Mesa creada con exito."));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo crear la mesa."));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $mesa = Mesa::TraerUno($id);
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    
    public function Modificar($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $mesa = Mesa::TraerUno($id);

        if(isset($parametros['idPedido']) && isset($parametros['idMozo']) && isset($parametros['estado']) && self::ValidarEstado($parametros['estado']))
        {
            $mesa->idPedido = $parametros['idPedido'];
            $mesa->idMozo = $parametros['idMozo'];
            $mesa->estado = $parametros['estado'];
            
            Mesa::ModificarMesa($mesa);
            $payload = json_encode(array("mensaje" => "Mesa modificada con exito."));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo modificar la mesa."));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }




    public function ValidarEstado($estado)
    {
        if($estado === "Esperando" || $estado === "Comiendo" || $estado === "Pagando" || $estado === "Cerrando")
        {
            return true;
        }
        else
        {
            return false;
        }
    }




}


?>