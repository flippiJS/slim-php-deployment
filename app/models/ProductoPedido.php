<?php

enum EstadoProducto: string
{
    case Realizado = 'Realizado';
    case Pendiente = 'Pendiente';
    case EnProceso = 'EnProceso';
}

class ProductoPedido
{
    public $id; 
    public $idProducto;
    public $idPedido;
    public $estado;

    public function __construct($idProducto, $idPedido, $estado) 
    {
        $this->idProducto = $idProducto;
        $this->idPedido = $idPedido;
        $this->estado = $estado;
    }
}




?>