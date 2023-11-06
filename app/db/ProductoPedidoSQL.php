<?php

//include 'AccesoDatos.php';

class ProductoPedidoSQL
{
    public static function InsertarProductoPedido($productoPedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $valor = $productoPedido->estado->value;
        echo $valor;

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productopedido (idProducto,idPedido,estado)values(:idProducto,:idPedido,:estado)");
        $consulta->bindValue(':idProducto', $productoPedido->idProducto);
        $consulta->bindValue(':idPedido', $productoPedido->idPedido);
        $consulta->bindValue(':estado', $valor);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM productopedido");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
