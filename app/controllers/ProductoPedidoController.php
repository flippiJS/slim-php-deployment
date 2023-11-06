<?php

include './models/ProductoPedido.php';
include './db/ProductoPedidoSQL.php';

class ProductoPedidoController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['idProducto']) && isset($parametros['idPedido']) && isset($parametros['estado']))
        {
            $productoPedido = new ProductoPedido($parametros['idProducto'], $parametros['idPedido'], EstadoProducto::from($parametros['estado']));
            ProductoPedidoSQL::InsertarProductoPedido($productoPedido);
            $payload = json_encode(array("mensaje" => "ProductoPedido creado con exito."));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo crear el ProductoPedido."));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = ProductoPedidoSQL::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }




}


?>