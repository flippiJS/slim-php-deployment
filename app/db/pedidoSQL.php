<?php

include 'AccesoDatos.php';

class PedidoSQL
{
    public static function InsertarPedido($pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $estado = $pedido->estado->value;

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into pedidos (id,nombreCliente,totalPrecio,estado,tiempoEstimado,numeroMesa)values(:id,:nombreCliente,:totalPrecio,:estado,:tiempoEstimado,:numeroMesa)");
        $consulta->bindValue(':id', $pedido->id);
        $consulta->bindValue(':nombreCliente', $pedido->nombreCliente);
        $consulta->bindValue(':totalPrecio', $pedido->totalPrecio);
        $consulta->bindValue(':estado', $estado);
        $consulta->bindValue(':tiempoEstimado', $pedido->tiempoEstimado);
        $consulta->bindValue(':numeroMesa', $pedido->numeroMesa);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}









?>