<?php

//include 'AccesoDatos.php';

class MesaSQL
{
    public static function InsertarMesa($mesa)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $estado = $mesa->estado->value;

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into mesas (idPedido,idMozo,estado)values(:idPedido,:idMozo,:estado)");
        $consulta->bindValue(':idPedido', $mesa->idPedido);
        $consulta->bindValue(':idMozo', $mesa->idMozo);
        $consulta->bindValue(':estado', $estado);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM mesas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function modificarMesa($mesa)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $estado = $mesa->estado->value;

        $consulta = $objAccesoDato->RetornarConsulta("UPDATE mesas SET idPedido = :idPedido, idMozo = :idMozo, estado = :estado WHERE id = :id");
        $consulta->bindValue(':idPedido', $mesa->idPedido);
        $consulta->bindValue(':idMozo', $mesa->idMozo);
        $consulta->bindValue(':estado', $estado);
        $consulta->bindValue(':id', $mesa->id);
        $consulta->execute();
    }

}





?>