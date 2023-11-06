<?php

enum  Rol: string
{
    case Bartender = 'Bartender';
    case Cervecero = 'Cervecero';
    case Cocinero = 'Cocinero';
    case Mozo = 'Mozo';
}

enum EstadoEmpleado: string
{
    case Presente = 'Presente';
    case Ausente = 'Ausente';
}

class Empleado
{
    public $id;
    public $rol;
    public $nombre;
    public $diponible;
    public $estado;

    public function __construct($rol, $nombre, $disponible, $estado) 
    {
        $this->rol = $rol;
        $this->nombre = $nombre;
        $this->disponible = $disponible;
        $this->estado = $estado;
    }

}



?>