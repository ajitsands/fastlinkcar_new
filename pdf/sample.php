<?php
require_once __DIR__ . '/vendor/autoload.php';

use TCPDF;

// Extend TCPDF
class MyPDF extends TCPDF {

    // Page header
    public function Header() {
        // Logo path
        $image_file = __DIR__ . '/../assets/img/logo_new/fastlinklogoblue.png';

        // Set logo
        $this->Image($image_file, 10, 10, 50); 
        // (x, y, width)

        // Set font
        $this->SetFont('helvetica', 'B', 14);

        // Move to the right
        $this->SetXY(50, 12);

        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 6, 'FAST LINK CO. W.L.L', 0, 1, 'R');
        
        $this->Ln(-0.5); // slight adjustment
        
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 4, 'SALMABAD - KINGDOM OF BAHRAIN', 0, 0, 'R');
    }
}

// Create PDF
$pdf = new MyPDF();
$pdf->AddPage();

// Body content
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(30); // Space after header
$pdf->Write(0, 'Invoice Content Here...');

$pdf->Output('test.pdf', 'I');