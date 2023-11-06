<?php

enum EstadoMesa: string
{
    case Esperando = 'Esperando';
    case Comiendo = 'Comiendo';
    case Pagando = 'Pagando';
    case Cerrado = 'Cerrado';
}

class Mesa
{
    public $id;
    public $idPedido;
    public $idMozo;
    public $estado;

    public function __construct($idPedido = null, $idMozo = null, $estado = Estado::Cerrado) 
    {
        $this->idPedido = $idPedido;
        $this->idMozo = $idMozo;
        $this->estado = $estado;
    }





}









?>