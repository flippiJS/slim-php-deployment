<?php

use Dompdf\Dompdf;

class GestorPDF
{
    public static function GestionarArchivosPDF($html,$nombreArchivo)
    {	    
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled'=>true));
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();
        $dompdf->stream($nombreArchivo,array("Attachment" => true));
    }     
}

?>