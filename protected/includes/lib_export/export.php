<?php

/* ini_set('display_errors', 1);
  error_reporting(E_ALL); */
define('ROOT_DIR', dirname(__FILE__));

class Resume_export {

    public static function docx($html, $fileName = "cv") {
        require_once ROOT_DIR . '/docx/classes/CreateDocx.inc';
        $docx = new CreateDocx();
        $docx->addHTML(array('html' => $html));
        $docx->createDocx($fileName);
        // /home/resume/public_html/images/resumes/Water-lilies.jpg
    }

    public static function docxImage($html, $fileName = "cv") {
        require_once ROOT_DIR . '/docx/classes/CreateDocx.inc';
        $docx = new CreateDocx();
        $string_out = $docx->addHTML(array('html' => $html));

//               $docx->embedHTML($html);
        $docx->createDocx($fileName);
    }

    public static function pdf($html, $fileName = "cv") {
        require_once(ROOT_DIR . "/pdf/dompdf_config.inc.php");                
        $dompdf = new DOMPDF();        
        $dompdf->load_html($html);

//        $dompdf->set_paper('a4', 'portrait');
        $dompdf->set_paper('Tabloid', 'portrait');
        $dompdf->render();
        $dompdf->stream($fileName . ".pdf", array("Attachment" => 0));
    }

    public static function generateDocx($html) {
        require_once ROOT_DIR . '/docx/classes/CreateDocx.inc';
        $docx = new CreateDocx();
        $docx->addHTML(array('html' => $html));
        $data = $docx->createDocx('get-data');
        return $data;
    }

    public static function generatePdf($html, $fileName = "cv") {
        require_once(ROOT_DIR . "/pdf/dompdf_config.inc.php");
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper('a4', 'portrait');
        $dompdf->render();
        $data = $dompdf->output();
        return $data;
    }

}
