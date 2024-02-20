<?php
    require_once './models/LogoEmpresa.php';
    require_once './controllers/LogController.php';

    class GestorPDFController //extends GestorPDF
    {
        public function DescargarLogoComanda($request, $response, $args)
        {
            /*
            $imagenLogo = 'C:/xampp/htdocs/comanda/Logo/LogoComanda.png';

            if(file_exists($imagenLogo))
            {
                echo "hay imágenes disponibles para crear el PDF.";
                $html = "<img src='https://centrofranchising.com/wp-content/uploads/2021/08/LA-COMANDA-LOGO-2.png' alt='LogoEmpresa'>";
                $nombreArchivo = "logoLaComanda.pdf";
                
                GestorPDF::generarPDFConImagen($html, $nombreArchivo);
                $payload = json_encode(array("Descargue el archivo accediendo a http://localhost:666/descargarLog"));
                LogController::CargarUno($request, "Descarga del logo de la empresa");  
            
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json'); 
            }
            else {
                // Si el archivo no existe, devolver una respuesta de error
                $payload = json_encode(array("error" => "El archivo no existe."));
                $response->getBody()->write($payload);
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }
            */

            // Ruta del archivo del logo de la empresa
            //$rutaLogo = 'C:/xampp/htdocs/comanda/Logo/LogoComanda.png';
            //$rutaLogo = LogoEmpresa::obtenerLogoEmpresa();

            $logoEmpresa = LogoEmpresa::obtenerLogoEmpresa();
            $rutaLogo = $logoEmpresa->logo;

            // Verificar si el archivo del logo existe
            if (is_file($rutaLogo)) 
            {
                // Crear una instancia de TCPDF
                require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // Establecer el título del documento y otros metadatos
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Nombre del autor');
                $pdf->SetTitle('Título del documento');
                $pdf->SetSubject('Asunto del documento');

                // Agregar una nueva página al PDF
                $pdf->AddPage();

                // Insertar el logo de la empresa en el PDF
                $pdf->Image($rutaLogo, 10, 10, 100, 0, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);


                // Enviar el PDF al navegador
                $pdf->Output('C:\Users\USUARIO\Downloads\logoEmpresa.pdf', 'F');

                // Registrar la acción en el log
                LogController::CargarUno($request, "Descarga del logo de la empresa");

                // Devuelve una respuesta de exito.
                $payload = json_encode(array("El logo se descargo con exito. Revice su carpeta de Descargas."));
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json'); 

            } else {
                // Si el archivo del logo no existe, devolver una respuesta de error
                $payload = json_encode(array("error" => "El archivo del logo de la empresa no existe."));
                $response->getBody()->write($payload);
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

        }

    }
?>