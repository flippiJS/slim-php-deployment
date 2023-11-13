<?php

include './models/producto.php';


class ProductoController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['nombre']) && isset($parametros['precio']) && isset($parametros['tipo']) && isset($parametros['tiempo']) && self::ValidarTipo($parametros['tipo']))
        {
            $producto = new Producto();
            $producto->nombre = $parametros['nombre'];
            $producto->precio = $parametros['precio'];
            $producto->tipo = $parametros['tipo'];
            $producto->tiempo = $parametros['tiempo'];
            Producto::InsertarProducto($producto);
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
        $lista = Producto::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $producto = Producto::TraerUno($id);
        $payload = json_encode($producto);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function Modificar($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $producto = Producto::TraerUno($id);

        if(isset($parametros['nombre']) && isset($parametros['precio']) && isset($parametros['tipo']) && isset($parametros['tiempo']) && self::ValidarTipo($parametros['tipo']))
        {
            $producto->nombre = $parametros['nombre'];
            $producto->precio = $parametros['precio'];
            $producto->tipo = $parametros['tipo'];
            $producto->tiempo = $parametros['tiempo'];

            Producto::ModificarProducto($producto);
            $payload = json_encode(array("mensaje" => "Producto modificado con exito."));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo modificar el producto."));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }



    public function ValidarTipo($tipo)
    {
        if($tipo === "Bartender" || $tipo === "Cocinero" || $tipo === "Cervecero")
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