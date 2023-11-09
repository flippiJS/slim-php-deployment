<?php

enum EstadoPedido: string
{
    case Preparacion = 'Preparacion';
    case Cancelado = 'Cancelado';
    case Entregado = 'Entregado';
}

class Pedido
{
    public $id;
    public $nombreCliente;
    //public $idProductoPedido; -- ARRAYS DE PRODUCTOS PEDIDOS
    public $totalPrecio;
    public $estado;
    public $tiempoEstimado;
    public $numeroMesa;

    public function __construct($id, $nombreCliente, $totalPrecio, $estado, $tiempoEstimado, $numeroMesa) 
    {
        $this->id = $id;
        $this->nombreCliente = $nombreCliente;
        //$this->idProductoPedido = $idProductoPedido;
        $this->totalPrecio = $totalPrecio;
        $this->estado = is_string($estado) ? EstadoPedido::from($estado) : $estado;
        $this->tiempoEstimado = $tiempoEstimado;
        $this->numeroMesa = $numeroMesa;
    }

    public static function GenerarId()
    {
        $id = "";
        $caracteres = "0123456789abcdefghijklmnopqrstuvwxyz";

        for($i = 0; $i < 5; $i++)
        {
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }

        return $id;
    }

    





}





?>