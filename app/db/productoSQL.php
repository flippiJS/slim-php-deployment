<?php

//include 'AccesoDatos.php';

class ProductoSQL
{
    public static function InsertarProducto($producto)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $valor = $producto->tipo->value;
        echo $valor;

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productos (nombre,precio,tipo,tiempo)values(:nombre,:precio,:tipo,:tiempo)");
        $consulta->bindValue(':nombre', $producto->nombre);
        $consulta->bindValue(':precio', $producto->precio);
        $consulta->bindValue(':tipo', $valor);
        $consulta->bindValue(':tiempo', $producto->tiempo);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    
}





?>