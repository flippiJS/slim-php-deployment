<?php

include './models/encuesta.php';


class EncuestaController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['idMesa']) && isset($parametros['nombreCliente']) && isset($parametros['descripcion']) && isset($parametros['puntuacionMesa'])
         && isset($parametros['puntuacionMozo']) && isset($parametros['puntuacionCocinero']) && isset($parametros['puntuacionRestaurant']))
        {
            $encuesta = new Encuesta();
            $encuesta->idMesa = $parametros['idMesa'];
            $encuesta->nombreCliente = $parametros['nombreCliente'];
            $encuesta->descripcion = $parametros['descripcion'];
            $encuesta->puntuacionMesa = $parametros['puntuacionMesa'];
            $encuesta->puntuacionMozo = $parametros['puntuacionMozo'];
            $encuesta->puntuacionCocinero = $parametros['puntuacionCocinero'];
            $encuesta->puntuacionRestaurant = $parametros['puntuacionRestaurant'];
            Encuesta::InsertarEncuesta($encuesta);
            $payload = json_encode(array("mensaje" => "Encuesta creado con exito."));
        }
        else
        {
            $payload = json_encode(array("error" => "No se pudo crear la encuesta."));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Encuesta::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $encuesta = Encuesta::TraerUno($id);
        $payload = json_encode($encuesta);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function Modificar($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $encuesta = Encuesta::TraerUno($id);

        if(isset($parametros['idMesa']) && isset($parametros['nombreCliente']) && isset($parametros['descripcion']) && isset($parametros['puntuacionMesa'])
           && isset($parametros['puntuacionMozo']) && isset($parametros['puntuacionCocinero']) && isset($parametros['puntuacionRestaurant']))
        {
            $encuesta->idMesa = $parametros['idMesa'];
            $encuesta->nombreCliente = $parametros['nombreCliente'];
            $encuesta->descripcion = $parametros['descripcion'];
            $encuesta->puntuacionMesa = $parametros['puntuacionMesa'];
            $encuesta->puntuacionMozo = $parametros['puntuacionMozo'];
            $encuesta->puntuacionCocinero = $parametros['puntuacionCocinero'];
            $encuesta->puntuacionRestaurant = $parametros['puntuacionRestaurant'];

            Encuesta::ModificarEncuesta($encuesta);
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

}


?>