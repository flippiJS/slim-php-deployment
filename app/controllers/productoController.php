<?php

include './models/producto.php';
include './db/productoSQL.php';

class ProductoController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['nombre']) && isset($parametros['precio']) && isset($parametros['tipo']) && isset($parametros['tiempo']))
        {
            $producto = new Producto($parametros['nombre'], $parametros['precio'], tipoProducto::from($parametros['tipo']), $parametros['tiempo']);
            ProductoSQL::InsertarProducto($producto);
            $payload = json_encode(array("mensaje" => "Producto creado con exito."));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo crear el producto."));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = ProductoSQL::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }




}


?>