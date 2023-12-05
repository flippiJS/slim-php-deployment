<?php

class Log
{
    public $id;
    public $idUsuario;
    public $fecha;
    public $operacion;

    public function crearLog()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO logs (idUsuario, fecha, operacion)
        VALUES (:idUsuario, :fecha, :operacion)");

        $consulta->bindValue(':idUsuario', $this->idUsuario, PDO::PARAM_INT);
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fecha = date('Y-m-d H:i:s');
        $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $consulta->bindValue(':operacion', $this->operacion, PDO::PARAM_STR);   

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function InformarOperacionesPorSector()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT u.perfil, COUNT(l.idUsuario) AS cantidad_operaciones 
        FROM logs l LEFT JOIN usuarios u ON l.idUsuario = u.id
        GROUP BY u.perfil");
        $consulta->execute();
        
        $resultados = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }

    public static function InformarOperacionesPorEmpleadoPorSector()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT l.idUsuario,u.nombre,u.perfil,COUNT(l.idUsuario) AS cantidad_operaciones 
        FROM logs l LEFT JOIN usuarios u ON l.idUsuario = u.id
        GROUP BY l.idUsuario,u.perfil
        ORDER BY u.perfil");
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public static function InformarLoginsPorEmpleado($idEmpleado)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT l.idUsuario,u.nombre,l.fecha,l.operacion 
        FROM logs l LEFT JOIN usuarios u ON l.idUsuario = u.id
        WHERE l.idUsuario=$idEmpleado AND l.operacion='Login'
        ORDER BY l.fecha");
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    public static function InformarOperacionesPorEmpleado($idEmpleado)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT l.idUsuario, u.nombre, l.fecha, l.operacion
        FROM logs l LEFT JOIN usuarios u ON l.idUsuario = u.id
        WHERE l.idUsuario=$idEmpleado");
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Log');
    }
}

?>