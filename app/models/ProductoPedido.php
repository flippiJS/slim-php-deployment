<?php

class ProductoPedido
{
    public $id; 
    public $idProducto;
    public $idPedido;
    public $estado;

    public static function InsertarProductoPedido($productoPedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productopedido (idProducto,idPedido,estado)values(:idProducto,:idPedido,:estado)");
        $consulta->bindValue(':idProducto', $productoPedido->idProducto);
        $consulta->bindValue(':idPedido', $productoPedido->idPedido);
        $consulta->bindValue(':estado', $productoPedido->estado);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM productopedido");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'ProductoPedido');
    }

    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM productopedido WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('ProductoPedido');
    }

}

?>