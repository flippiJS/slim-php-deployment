<?php

include "./db/AccesoDatos.php";

class Producto
{
    public $id;
    public $nombre;
    public $precio;
    public $tipo; 
    public $tiempo;

    public static function InsertarProducto($producto)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productos (nombre,precio,tipo,tiempo)values(:nombre,:precio,:tipo,:tiempo)");
        $consulta->bindValue(':nombre', $producto->nombre);
        $consulta->bindValue(':precio', $producto->precio);
        $consulta->bindValue(':tipo', $producto->tipo);
        $consulta->bindValue(':tiempo', $producto->tiempo);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public static function ModificarProducto($producto)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre, precio = :precio, tipo = :tipo, tiempo = :tiempo WHERE id = :id");
        $consulta->bindValue(':nombre', $producto->nombre);
        $consulta->bindValue(':precio', $producto->precio);
        $consulta->bindValue(':tipo', $producto->tipo);
        $consulta->bindValue(':tiempo', $producto->tiempo);
        $consulta->bindValue(':id', $producto->id);
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