<?php

include 'AccesoDatos.php';
//include './models/pedido.php';

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

    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function modificarPedido($pedido)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $estado = $pedido->estado->value;
        $consulta = $objAccesoDato->RetornarConsulta("UPDATE pedidos SET nombreCliente = :nombreCliente, totalPrecio = :totalPrecio, estado = :estado, tiempoEstimado = :tiempoEstimado, numeroMesa = :numeroMesa WHERE id = :id");
        $consulta->bindValue(':id', $pedido->id);
        $consulta->bindValue(':nombreCliente', $pedido->nombreCliente);
        $consulta->bindValue(':totalPrecio', $pedido->totalPrecio);
        $consulta->bindValue(':estado', $estado);
        $consulta->bindValue(':tiempoEstimado', $pedido->tiempoEstimado);
        $consulta->bindValue(':numeroMesa', $pedido->numeroMesa);
        $consulta->execute();
    }

    /*public function VerificarIdUnico()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $id = Pedido::GenerarId();

        $consulta = $objAccesoDatos->RetornarConsulta("SELECT COUNT(*) FROM pedidos WHERE id=$id");
        $consulta->execute();
        echo $consulta;

        if($consulta > 0)
        {
            echo "si hau";
        }
        else
        {
            echo "se retorna pa";
        }


    }*/

}









?>