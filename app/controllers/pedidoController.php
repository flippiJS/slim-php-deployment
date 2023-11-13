<?php

include './models/pedido.php';


class PedidoController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['nombreCliente']) && isset($parametros['totalPrecio']) && isset($parametros['tiempoEstimado']) && isset($parametros['numeroMesa']))
        {
            $pedido = new Pedido();
            $pedido->id = self::GenerarId();
            $pedido->nombreCliente = $parametros['nombreCliente']; // aca esta igual y anda
            $pedido->totalPrecio = $parametros['totalPrecio'];
            $pedido->estado = "Preparacion";
            $pedido->tiempoEstimado = $parametros['tiempoEstimado'];
            $pedido->numeroMesa = $parametros['numeroMesa'];
            Pedido::InsertarPedido($pedido);
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
        $lista = Pedido::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $pedido = Pedido::TraerUno($id);
        $payload = json_encode($pedido);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function Modificar($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $pedido = Pedido::TraerUno($id);

        if(isset($parametros['nombreCliente']) && isset($parametros['totalPrecio']) && isset($parametros['estado']) && isset($parametros['tiempoEstimado']) 
        && isset($parametros['numeroMesa']) && self::ValidarEstado($parametros['estado']))
        {
            $pedido->nombreCliente = $parametros['nombreCliente'];
            $pedido->totalPrecio = $parametros['totalPrecio'];
            $pedido->estado = $parametros['estado'];
            $pedido->tiempoEstimado = $parametros['tiempoEstimado'];
            $pedido->numeroMesa = $parametros['numeroMesa'];

            Pedido::ModificarPedido($pedido);
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

    public function Eliminar($request, $response, $args)
    {
        $id = $args['id'];
        $pedido = Pedido::TraerUno($id);

        Pedido::BorrarPedido($pedido);
        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function GenerarId()
    {
        $id = "";
        $caracteres = "0123456789abcdefghijklmnopqrstuvwxyz";

        for($i = 0; $i < 5; $i++)
        {
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }

        return $id;
    }

    public function ValidarEstado($estado)
    {
        if($estado === "Preparacion" || $estado === "Cancelado" || $estado === "Entregado")
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