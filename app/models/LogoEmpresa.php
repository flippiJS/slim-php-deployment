<?php

require_once './db/AccesoDatos.php';

class LogoEmpresa
{

    public $logo;

    public static function obtenerLogoEmpresa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM logoempresa");
        $consulta->execute();

        //return $consulta->fetchAll(PDO::FETCH_CLASS, 'LogoEmpresa');
        return $consulta->fetchObject('LogoEmpresa');
    }
}

?>