<?php

class Encuesta
{
    public $id;
    public $idMesa;
    public $nombreCliente;
    public $descripcion;
    public $puntuacionMesa;
    public $puntuacionMozo;
    public $puntuacionCocinero;
    public $puntuacionRestaurant;

    public static function InsertarEncuesta($encuesta)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into encuestas (idMesa,nombreCliente,descripcion,puntuacionMesa,puntuacionMozo,puntuacionCocinero,puntuacionRestaurant)values(:idMesa,:nombreCliente,:descripcion,:puntuacionMesa,:puntuacionMozo,:puntuacionCocinero,:puntuacionRestaurant)");
        $consulta->bindValue(':idMesa', $encuesta->idMesa);
        $consulta->bindValue(':nombreCliente', $encuesta->nombreCliente);
        $consulta->bindValue(':descripcion', $encuesta->descripcion);
        $consulta->bindValue(':puntuacionMesa', $encuesta->puntuacionMesa);
        $consulta->bindValue(':puntuacionMozo', $encuesta->puntuacionMozo);
        $consulta->bindValue(':puntuacionCocinero', $encuesta->puntuacionCocinero);
        $consulta->bindValue(':puntuacionRestaurant', $encuesta->puntuacionRestaurant);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM encuestas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Encuesta');
    }

    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM encuestas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Encuesta');
    }

    public static function modificarEncuesta($encuesta)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDato->RetornarConsulta("UPDATE encuestas SET idMesa = :idMesa, nombreCliente = :nombreCliente, descripcion = :descripcion, puntuacionMesa = :puntuacionMesa, puntuacionMozo = :puntuacionMozo, puntuacionCocinero = :puntuacionCocinero, puntuacionRestaurant = :puntuacionRestaurant WHERE id = :id");
        $consulta->bindValue(':idMesa', $encuesta->idMesa);
        $consulta->bindValue(':nombreCliente', $encuesta->nombreCliente);
        $consulta->bindValue(':descripcion', $encuesta->descripcion);
        $consulta->bindValue(':puntuacionMesa', $encuesta->puntuacionMesa);
        $consulta->bindValue(':puntuacionMozo', $encuesta->puntuacionMozo);
        $consulta->bindValue(':puntuacionCocinero', $encuesta->puntuacionCocinero);
        $consulta->bindValue(':puntuacionRestaurant', $encuesta->puntuacionRestaurant);
        $consulta->bindValue(':id', $encuesta->id);
        $consulta->execute();
    }


}





?>