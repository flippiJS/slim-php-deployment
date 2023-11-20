<?php
require_once './models/GestorPDF.php';
require_once './controllers/LogController.php';

class GestorPDFController extends GestorPDF
{
    public function DescargarLogoComanda($request, $response, $args)
    {
        $html = "<img src='https://centrofranchising.com/wp-content/uploads/2021/08/LA-COMANDA-LOGO-2.png' alt='LogoEmpresa'>";
        $nombreArchivo = "logoLaComanda.pdf";
        
        GestorPDF::GestionarArchivosPDF($html, $nombreArchivo);
        $payload = json_encode(array("Descargue el archivo accediendo a http://localhost:666/descargarLog"));
        LogController::CargarUno($request, "Descarga del logo de la empresa");  
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    } 
}

?>