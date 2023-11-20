<?php

require_once './db/AccesoDatos.php';

class Usuario
{
    public $id;
    public $nombre;
    public $clave;
    public $perfil;
    public $fechaAlta;
    public $fechaBaja;

    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (nombre, clave, perfil, fechaAlta) 
        VALUES (:nombre, :clave, :perfil,:fechaAlta)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':fechaAlta', $this->fechaAlta, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function crearUsuarioDesdeCsv($archivo)
    {
        $array = GestorCSV::LeerCsv($archivo);
        
        for($i = 0; $i < sizeof($array); $i++)
        {
            $datos = explode(",", $array[$i]); 
            $usuarioAux = new Usuario();
            $usuarioAux->id = $datos[0];
            $usuarioAux->nombre = $datos[1];
            $usuarioAux->clave = $datos[2];
            $usuarioAux->perfil = $datos[3];
            $usuarioAux->fechaAlta = $datos[4];
            $usuarioAux->fechaBaja = $datos[5];
            $usuarioAux->crearUsuario();
        }
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function obtenerUsuarioPorId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE id = :id and fechaBaja is null");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    } 

    public static function modificarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET 
        nombre=:nombre, clave = :clave, perfil= :perfil, fechaAlta=:fechaAlta,fechaBaja=:fechaBaja WHERE id = :id");
        $consulta->bindValue(':id', $usuario->id, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $claveHash = password_hash($usuario->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':clave', $claveHash, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $usuario->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':fechaAlta', $usuario->fechaAlta, PDO::PARAM_STR);

        if($usuario->fechaBaja != null)
        {
            $consulta->bindValue(':fechaBaja', $usuario->fechaBaja, PDO::PARAM_STR);
        }
        else
        {
            $consulta->bindValue(':fechaBaja', null, PDO::PARAM_STR);
        }

        return $consulta->execute();
    }

    public static function borrarUsuario($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET fechaBaja = :fechaBaja WHERE id = :id");
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fechaBaja = date("Y-m-d H:i:s");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', $fechaBaja);

        return $consulta->execute();
    }
    
}
?>