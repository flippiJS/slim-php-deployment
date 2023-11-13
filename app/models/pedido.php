<?php

class Pedido
{
    public $id;
    public $nombreCliente;
    //public $idProductoPedido; -- ARRAYS DE PRODUCTOS PEDIDOS
    public $totalPrecio;
    public $estado;
    public $tiempoEstimado;
    public $numeroMesa;

    public static function InsertarPedido($pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into pedidos (id,nombreCliente,totalPrecio,estado,tiempoEstimado,numeroMesa)values(:id,:nombreCliente,:totalPrecio,:estado,:tiempoEstimado,:numeroMesa)");
        $consulta->bindValue(':id', $pedido->id);
        $consulta->bindValue(':nombreCliente', $pedido->nombreCliente);
        $consulta->bindValue(':totalPrecio', $pedido->totalPrecio);
        $consulta->bindValue(':estado', $pedido->estado);
        $consulta->bindValue(':tiempoEstimado', $pedido->tiempoEstimado);
        $consulta->bindValue(':numeroMesa', $pedido->numeroMesa);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public static function modificarPedido($pedido)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objAccesoDato->RetornarConsulta("UPDATE pedidos SET nombreCliente = :nombreCliente, totalPrecio = :totalPrecio, estado = :estado, tiempoEstimado = :tiempoEstimado, numeroMesa = :numeroMesa WHERE id = :id");
        $consulta->bindValue(':id', $pedido->id);
        $consulta->bindValue(':nombreCliente', $pedido->nombreCliente);
        $consulta->bindValue(':totalPrecio', $pedido->totalPrecio);
        $consulta->bindValue(':estado', $pedido->estado);
        $consulta->bindValue(':tiempoEstimado', $pedido->tiempoEstimado);
        $consulta->bindValue(':numeroMesa', $pedido->numeroMesa);
        $consulta->execute();
    }

    public static function BorrarPedido($pedido)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDato->RetornarConsulta("UPDATE pedidos SET estado = :estado WHERE id = :id");
        $consulta->bindValue(':id', $pedido->id);
        $consulta->bindValue(':estado', "Cancelado");
        $consulta->execute();
    }

}





?>