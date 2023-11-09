<?php

include './models/encuesta.php';
include './db/encuestaSQL.php';

class EncuestaController
{
    public function Insertar($request, $response, $args)
    {

        $parametros = $request->getParsedBody();

        if(isset($parametros['idMesa']) && isset($parametros['nombreCliente']) && isset($parametros['descripcion']) && isset($parametros['puntuacionMesa'])
         && isset($parametros['puntuacionMozo']) && isset($parametros['puntuacionCocinero']) && isset($parametros['puntuacionRestaurant']))
        {
            $encuesta = new Encuesta($parametros['idMesa'], $parametros['nombreCliente'], $parametros['descripcion'], $parametros['puntuacionMesa'], $parametros['puntuacionMozo'], $parametros['puntuacionCocinero'], $parametros['puntuacionRestaurant']);
            EncuestaSQL::InsertarEncuesta($encuesta);
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
        $lista = EncuestaSQL::TraerTodos();

        $payload = json_encode($lista);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $encuesta = EncuestaSQL::TraerUno($id);
        $payload = json_encode($encuesta);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


}


?>