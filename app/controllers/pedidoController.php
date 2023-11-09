<?php

include './models/pedido.php';
include './db/pedidoSQL.php';

class PedidoController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['nombreCliente']) && isset($parametros['totalPrecio']) && isset($parametros['estado']) && isset($parametros['tiempoEstimado']) && isset($parametros['numeroMesa']))
        {
            $pedido = new Pedido($parametros['nombreCliente'], $parametros['totalPrecio'], EstadoPedido::from($parametros['estado']), $parametros['tiempoEstimado'], $parametros['numeroMesa']);
            PedidoSQL::InsertarPedido($pedido);
            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo crear el pedido"));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = PedidoSQL::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $pedido = PedidoSQL::TraerUno($id);
        $payload = json_encode($pedido);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    

}



?>