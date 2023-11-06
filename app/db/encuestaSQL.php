<?php

//include 'AccesoDatos.php';

class EncuestaSQL
{
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

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

}





?>