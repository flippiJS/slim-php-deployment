<?php

class Mesa
{
    public $id;
    public $idPedido;
    public $idMozo;
    public $estado;

    public static function InsertarMesa($mesa)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into mesas (idPedido,idMozo,estado)values(:idPedido,:idMozo,:estado)");
        $consulta->bindValue(':idPedido', $mesa->idPedido);
        $consulta->bindValue(':idMozo', $mesa->idMozo);
        $consulta->bindValue(':estado', $mesa->estado);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }
    
    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM mesas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }

    public static function modificarMesa($mesa)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objAccesoDato->RetornarConsulta("UPDATE mesas SET idPedido = :idPedido, idMozo = :idMozo, estado = :estado WHERE id = :id");
        $consulta->bindValue(':idPedido', $mesa->idPedido);
        $consulta->bindValue(':idMozo', $mesa->idMozo);
        $consulta->bindValue(':estado', $mesa->estado);
        $consulta->bindValue(':id', $mesa->id);
        $consulta->execute();
    }

    public static function BorrarProducto($producto)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDato->RetornarConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $producto->id);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }



}









?>