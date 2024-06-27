<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PdfConverter {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->library('tcpdf/tcpdf');
    }

    public function convert($file_path) {
        // Verificar se o arquivo existe
        if (!file_exists($file_path)) {
            return FALSE;
        }

        // Configurações TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Adicionar nova página
        $pdf->AddPage();

        // Definir conteúdo do PDF
        $pdf->setSourceFile($file_path);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 10, 10, 200);

        // Nome do arquivo PDF a ser salvo
        $pdf_file = 'converted_file.pdf';  // Nome do arquivo PDF
        $pdf_file_path = './uploads/' . $pdf_file;

        // Salvar o arquivo PDF
        $pdf->Output($pdf_file_path, 'F');

        return $pdf_file_path;
    }

}
?>
