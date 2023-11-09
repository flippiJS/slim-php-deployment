<?php

include './models/mesa.php';
include './db/mesaSQL.php';

class MesaController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['idPedido']) && isset($parametros['idMozo']) && isset($parametros['estado']))
        {
            $mesa = new Mesa($parametros['idPedido'], $parametros['idMozo'], EstadoMesa::from($parametros['estado']));
            MesaSQL::InsertarMesa($mesa);
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
        $lista = MesaSQL::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $mesa = MesaSQL::TraerUno($id);
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


}


?>