<?php

//include 'AccesoDatos.php';

class EmpleadoSQL
{
    public static function InsertarEmpleado($empleado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $rol = $empleado->rol->value;
        $estado = $empleado->estado->value;

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into empleados (rol,nombre,disponible,estado)values(:rol,:nombre,:disponible,:estado)");
        $consulta->bindValue(':rol', $rol);
        $consulta->bindValue(':nombre', $empleado->nombre);
        $consulta->bindValue(':disponible', $empleado->disponible);
        $consulta->bindValue(':estado', $estado);
        $consulta->execute();
    }

    public static function TraerTodos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM empleados");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function TraerUno($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM empleados WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function modificarEmpleado($empleado)
    {
        $objAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $estado = $empleado->estado->value;
        $consulta = $objAccesoDato->RetornarConsulta("UPDATE empleados SET rol = :rol, nombre = :nombre, disponible = :disponible, estado = :estado WHERE id = :id");
        $consulta->bindValue(':rol', $rol);
        $consulta->bindValue(':nombre', $empleado->nombre);
        $consulta->bindValue(':disponible', $empleado->disponible);
        $consulta->bindValue(':estado', $estado);
        $consulta->bindValue(':id', $$empleado->id);
        $consulta->execute();
    }

}


?>