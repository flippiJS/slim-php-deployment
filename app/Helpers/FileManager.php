<?php

namespace Helpers;

use Throwable;

class FileManager
{
    private static $instance = null;
    private $filePath = '';
    private $imagePath = '';

    private function __construct()
    {
        $this->filePath = '/ruta/de/tu/directorio/';
        $this->imagePath = '/ruta/de/tu/directorio/';
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setFilePath($path)
    {
        $this->filePath = $path;
    }

    public function setImagePath($path)
    {
        $this->imagePath = $path;
    }

    public function toJSON($fileName, $data)
    {
        $status = true;

        $json = json_encode($data, JSON_PRETTY_PRINT);

        if ($json) {
            if (is_string($fileName)) {
                try {
                    $file = fopen($this->filePath . '/' . $fileName, 'w');
                    if ($file) {
                        if (fwrite($file, $json) === false) {
                            $status = 'Ocurrió un error al escribir en el archivo';
                        }
                        fclose($file);
                    } else {
                        $status = 'Ocurrió un error al abrir el archivo';
                    }
                } catch (Throwable $e) {
                    $status = "Ocurrió una excepción: .$e";
                }
            } else {
                $status = 'El nombre del archivo no es una cadena válida';
            }
        } else {
            $status = 'No se pudo convertir a JSON';
        }

        return $status;
    }

    public function getJSON($fileName)
    {
        $data = array();
        $file = null;
        try
        {
            if (file_exists($this->filePath.$fileName)) {
                if (is_string($fileName)) {
                    $file = fopen($this->filePath.$fileName, 'r');
                    if($file)
                    {
                        $content = fread($file, filesize($this->filePath.$fileName));
                        $data = json_decode($content, true);
                    }else
                    {
                        echo ("No se abrió el archivo");
                    }
                }
            }
        }
        catch (Throwable $mensaje)
        {
            echo("Error al leer el archivo:  $mensaje");
        }
        finally
        {
            if ($file !== null) {
                fclose($file);
            }
            return $data;
        }
    }

    public function saveImage($keyImagenPost, $nameImage)
    {
        $origen = $_FILES[$keyImagenPost]['tmp_name'];

        $explodeString = explode('/', $_FILES[$keyImagenPost]['type']);
        $explodeString = array_reverse($explodeString);
        $extensionImagen = $explodeString[0];

        $destino = $this->imagePath . $nameImage . '.' . $extensionImagen;

        return move_uploaded_file($origen, $destino);
    }

    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
}
