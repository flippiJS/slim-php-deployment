<?php

class GestorCSV
{
    public static function EscribirCSV($ruta,$listaUsuarios)
    {
        if($listaUsuarios !=NULL)
        {
            $archivo = fopen($ruta, "w+");
            foreach($listaUsuarios as $item)
            {
                $separadoPorComa = implode(",", (array)$item);  
                if($archivo)
                {
                    fwrite($archivo, $separadoPorComa.",\r\n"); 
                }                           
            }
            fclose($archivo);  
            return $ruta;    
        }
    }

    public static function LeerCsv($archivo)
    {
        if($archivo!=NULL)
        {
            $auxArchivo = fopen($archivo, "r");
            $array = [];    
            try
            {
                while(!feof($auxArchivo))
                {
                    $datos = fgets($auxArchivo);                        
                    if(!empty($datos))
                    {          
                        array_push($array, $datos);                                                
                    }
                }
            }
            catch(Exception $ex)
            {
                echo "No se pudo leer el archivo debido al siguiente error: " . $ex->getMessage();
            }
            finally
            {
                fclose($auxArchivo);
                return $array;
            }
        }
    }
}

?>