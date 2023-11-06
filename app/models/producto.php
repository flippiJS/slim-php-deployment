<?php

enum tipoProducto: string
{
    case Bartender = 'Bartender';
    case Cervecero = 'Cervecero';
    case Cocinero = 'Cocinero';
}

class Producto
{
    public $id;
    public $nombre;
    public $precio;
    public $tipo; 
    public $tiempo;

    /*public function __construct() 
    {
        
    }*/

    public function __construct($nombre, $precio, $tipo, $tiempo) 
    {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->tipo = is_string($tipo) ? tipoProducto::from($tipo) : $tipo;
        $this->tiempo = $tiempo;
    }


}



?>