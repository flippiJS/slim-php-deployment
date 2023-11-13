<?php

include './models/ProductoPedido.php';


class ProductoPedidoController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['idProducto']) && isset($parametros['idPedido']) && isset($parametros['estado']))
        {
            $productoPedido = new ProductoPedido();
            $productoPedido->idProducto = $parametros['idProducto'];
            $productoPedido->idPedido =  $parametros['idPedido'];
            $productoPedido->estado = $parametros['estado'];
            ProductoPedido::InsertarProductoPedido($productoPedido);
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
        $lista = ProductoPedido::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $productoPedido = ProductoPedido::TraerUno($id);
        $payload = json_encode($productoPedido);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }




}


?>