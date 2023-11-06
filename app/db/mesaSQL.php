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

}





?>