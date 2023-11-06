<?php

class Encuesta
{
    public $idMesa;
    public $nombreCliente;
    public $descripcion;
    public $puntuacionMesa;
    public $puntuacionMozo;
    public $puntuacionCocinero;
    public $puntuacionRestaurant;

    public function __construct($idMesa, $nombreCliente, $descripcion, $puntuacionCocinero, $puntuacionMesa, $puntuacionMozo, $puntuacionRestaurant) 
    {
        $this->idMesa = $idMesa;
        $this->nombreCliente = $nombreCliente;
        $this->descripcion = $descripcion;
        $this->puntuacionCocinero = $puntuacionCocinero;
        $this->puntuacionMesa = $puntuacionMesa;
        $this->puntuacionMozo = $puntuacionMozo;
        $this->puntuacionRestaurant = $puntuacionRestaurant;
    }


}





?>