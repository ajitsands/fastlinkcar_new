<?php

require_once __DIR__ . '/tcpdf_include.php';

// Fallback environment loader if accessed directly
if (empty($_ENV['DB_HOST']) || empty($_ENV['DB_NAME'])) {
    $possibleEnv = [
        dirname(__DIR__) . '/envfiles/.env',
        __DIR__ . '/../envfiles/.env',
        __DIR__ . '/.env'
    ];
    foreach ($possibleEnv as $f) {
        if (file_exists($f)) {
            $lines = file($f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || $line[0] === '#') continue;
                if (strpos($line, '=') !== false) {
                    list($key, $val) = explode('=', $line, 2);
                    $key = trim($key);
                    $val = trim($val, " \t\n\r\0\x0B\"'");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                    putenv("$key=$val");
                }
            }
            break;
        }
    }
}

// Database configurations
$dbHost = $_ENV['DB_HOST'] ?? (defined('DB_HOST') ? DB_HOST : 'localhost');
$dbUser = $_ENV['DB_USER'] ?? (defined('DB_USER') ? DB_USER : 'root');
$dbPass = $_ENV['DB_PASS'] ?? (defined('DB_PASS') ? DB_PASS : '');
$dbName = $_ENV['DB_NAME'] ?? (defined('DB_NAME') ? DB_NAME : 'sandsl23_aa_car_rental');

if (!defined('DB_HOST')) define('DB_HOST', $dbHost);
if (!defined('DB_USER')) define('DB_USER', $dbUser);
if (!defined('DB_PASS')) define('DB_PASS', $dbPass);
if (!defined('DB_NAME')) define('DB_NAME', $dbName);

if (isset($_ENV['APP_TIMEZONE'])) {
    date_default_timezone_set($_ENV['APP_TIMEZONE']);
}

// Support for POST or GET parameters
$params = !empty($_POST) ? $_POST : $_GET;

$quotation_id = $params['id'] ?? 1;
$orientation = (isset($params['orientation']) && strtoupper($params['orientation']) == 'P') ? 'P' : 'L';
$font_size_table = isset($params['font_size_table']) ? (float) $params['font_size_table'] : 8;
$footer_logo_x = isset($params['footer_logo_x']) ? (float) $params['footer_logo_x'] : 15;
$footer_logo_y = isset($params['footer_logo_y']) ? (float) $params['footer_logo_y'] : -35;
$footer_logo_pg = $params['footer_logo_pg'] ?? 'last'; // 'last' or 'all'
$page_break_threshold = isset($params['page_break_threshold']) ? (float) $params['page_break_threshold'] : 30; // Reduced default to 30

$seal_last_pg = $params['seal_last_pg'] ?? 'last_center';
$seal_last_x = isset($params['seal_last_x']) ? (float) $params['seal_last_x'] : 0;
$seal_last_y = isset($params['seal_last_y']) ? (float) $params['seal_last_y'] : 0;

// Database Connection
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sample_mode = false;
if ($mysqli->connect_error) {
    $sample_mode = true;
}

if (!$sample_mode) {
    $stmt = $mysqli->prepare("SELECT * FROM quotations WHERE id = ?");
    $stmt->bind_param("i", $quotation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if (!$data)
        $sample_mode = true;
}

if ($sample_mode) {
    $data = [
        'quotation_no' => 'AA/2026/CMN2939',
        'quotation_date' => '2026-02-16',
        'customer_name' => 'SAMPLE CUSTOMER W.L.L',
        'customer_email' => 'customer@example.com',
        'attention' => 'To Whom It May Concern',
        'items' => json_encode([
            ['item_name' => 'TOYOTA LAND CRUISER', 'service_type' => 'Rental Without Driver', 'period_from' => '17-02-26', 'period_to' => '19-03-26', 'months_days' => '1', 'qty' => 1, 'price' => 10.000, 'vat' => 10, 'total' => 11.000],
            ['item_name' => 'TOYOTA LAND CRUISER PRADO', 'service_type' => 'Rental With Driver', 'period_from' => '17-02-26', 'period_to' => '19-03-26', 'months_days' => '1', 'qty' => 1, 'price' => 10.000, 'vat' => 0, 'total' => 10.000]
        ])
    ];
}

$quotation_no = $data['quotation_no'];
$quotation_date = date('d-m-Y', strtotime($data['quotation_date']));
$customer_name = $data['customer_name'];
$customer_email = $data['customer_email'];
$attention = $data['attention'] ?? '';
$introduction = !empty($data['introduction']) ? $data['introduction'] : "With reference to your inquiry regarding the rental of Vehicles, we are pleased to quote our best prices as mention below:";
$custom_notes = !empty($data['terms']) ? $data['terms'] : ($params['notes'] ?? "");
$items = json_decode($data['items'], true);
$customer_address = $data['customer_address'];

class AA_PDF extends TCPDF
{
    public $footer_logo_x;
    public $footer_logo_y;
    public $footer_logo_pg;
    public $seal_pg;

    public function Header()
    {
        $logo_file = '../assets/img/logo/logo.png';
        if (file_exists($logo_file)) {
            $this->Image($logo_file, 20, 5, 45, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        $this->SetFont('helvetica', 'B', 18);
        $this->SetXY(20, 7);
        $this->Cell(0, 10, 'AA CAR RENTAL CO. W.L.L', 0, 1, 'R');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'SALMABAD- KINGDOM OF BAHRAIN', 0, 1, 'R');
    }

    public function Footer()
    {
        $this->SetY(-30);
        $this->Line(20, $this->GetY(), $this->getPageWidth() - 15, $this->GetY());
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 11);
        $this->Cell(0, 6, 'AA CAR RENTAL', 0, 1, 'L');
        $this->SetFont('dejavusans', '', 8);
        $html = '<table width="100%" border="0" cellpadding="1">
            <tr>
                <td width="35%"><b>+ 973 17300311 | + 973 17300322</b></td>
                <td width="25%" align="center"><b>info@aarental.com</b></td>
                <td width="40%" align="right"><b>Salmabad - Kingdom of Bahrain</b></td>
            </tr>
            <tr>
                <td colspan="3" align="right" style="font-family:dejavusans;">سلماباد - مملكة البحرين</td>
            </tr>
        </table>';
        $this->writeHTML($html, true, false, true, false, '');

        // Bottom Logo Logic
        $is_last_page = ($this->getPage() == $this->getNumPages());
        if ($this->footer_logo_pg == 'all' || ($this->footer_logo_pg == 'last' && $is_last_page)) {
            $logo_file = '../assets/img/logo/logo.png';
            if (file_exists($logo_file)) {
                // Handle negative Y as offset from bottom
                $y_pos = ($this->footer_logo_y < 0) ? $this->getPageHeight() + $this->footer_logo_y : $this->footer_logo_y;
                $this->Image($logo_file, $this->footer_logo_x, $y_pos, 40, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }
        }

        // --- Standard Seal & Signature (L/C/R) - ALL PAGES ---
        if (!empty($this->seal_pg) && strpos($this->seal_pg, 'last_') === 0 && $this->seal_pg !== 'last_custom') {
            $seal_file = 'logos/seal_and_sig.png';
            if (!file_exists($seal_file)) {
                $seal_file = '../assets/img/logo/seal_and_sig.png';
            }
            if (file_exists($seal_file)) {
                $img_w = 35;
                $page_w = $this->getPageWidth();
                $page_h = $this->getPageHeight();
                $orientation = ($page_w > $page_h) ? 'L' : 'P';
                
                $y_val = ($orientation == 'L') ? -50 : -60;
                $y_pos = $page_h + $y_val;
                
                $mode = str_replace('last_', '', $this->seal_pg);
                if ($mode === 'left') $x_pos = 20;
                elseif ($mode === 'center') $x_pos = ($page_w - $img_w) / 2;
                elseif ($mode === 'right') $x_pos = $page_w - 15 - $img_w;

                $this->Image($seal_file, $x_pos, $y_pos, $img_w, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }
        }

        $this->SetY(-10);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C');
    }
}

$pdf = new AA_PDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->footer_logo_x = $footer_logo_x;
$pdf->footer_logo_y = $footer_logo_y;
$pdf->footer_logo_pg = $footer_logo_pg;
$pdf->seal_pg = $seal_last_pg;

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Quotation ' . $quotation_no);
$pdf->SetMargins(20, 28, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(25);
$pdf->SetAutoPageBreak(TRUE, $page_break_threshold);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Red Bar "QUOTATION"
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->Ln(5);
$pdf->SetFillColor(237, 28, 36);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 12, 'QUOTATION', 0, 1, 'C', 1);

// Client & Metadata
$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$startY = $pdf->GetY();
$colWidth = ($pdf->getPageWidth() - 35) / 2;

// Left Info
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(15, 6, 'M/S.', 0, 0);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->Cell($colWidth - 15, 6, strtoupper($customer_name), 0, 1);
$pdf->SetX(35);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($colWidth - 15, 5, $customer_address, 0, 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(20);
$pdf->SetFont('dejavusans', '', 9); // Use dejavusans for better consistency with HTML
$html_info = '
<table border="0" cellpadding="0">
    <tr>
        <td width="50"><b>Attn :</b></td>
        <td width="350">' . $attention . '</td>
    </tr>
    <tr>
        <td width="50" style="padding-top:10px;"><b>Email :</b></td>
        <td width="350" style=" padding-top:10px;">' . $customer_email . '</td>
    </tr>
</table>';
$pdf->writeHTMLCell($colWidth, 0, 20, $pdf->GetY(), $html_info, 0, 1, 0, true, 'L', true);

// Right Info (Date/No) - Right aligned labels
$pdf->SetXY(20 + $colWidth, $startY);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($colWidth - 30, 6, 'Date:', 0, 0, 'R');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(30, 6, $quotation_date, 0, 1, 'R');
$pdf->SetX(20 + $colWidth);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($colWidth - 30, 6, 'Qtn. No:', 0, 0, 'R');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(30, 6, $quotation_no, 0, 1, 'R');

$pdf->Ln(8);
$pdf->SetFont('helvetica', '', 10);
$pdf->SetMargins(21, 28, 15); // left, top, right
$pdf->writeHTML($introduction, true, false, true, false, 'L');

// Table scaling
$pdf->SetMargins(20, 28, 15); // left, top, right
$pdf->Ln(5);
$availWidth = $pdf->getPageWidth() - 35;
$p = ['no' => 4, 'car' => 17, 'service' => 12, 'period' => 18, 'months' => 8, 'qty' => 5, 'unit' => 9, 'excl' => 10, 'vat_p' => 4, 'vat_a' => 5, 'incl' => 8];
$total_p = array_sum($p);
$w = [];
foreach ($p as $k => $v) {
    $w[$k] = ($v / $total_p) * $availWidth;
}

$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('helvetica', 'B', $font_size_table);
$h_h = 14;
$pdf->MultiCell($w['no'], $h_h, "No", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['car'], $h_h, "Type of Car", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['service'], $h_h, "Service Type", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['period'], $h_h, "PERIOD", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['months'], $h_h, "Duration", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['qty'], $h_h, "Qty", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['unit'], $h_h, "Unit Price(BHD)", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['excl'], $h_h, "Amount Excl of VAT(BHD)", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['vat_p'], $h_h, "VAT %", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['vat_a'], $h_h, "VAT Amount", 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['incl'], $h_h, "Amount incl of VAT(BHD)", 1, 'C', 1, 1, '', '', true, 0, false, true, $h_h, 'M');

$pdf->SetFont('helvetica', '', $font_size_table);
$count = 1;
$grand_total = 0;
foreach ($items as $item) {
    $qty = (float) ($item['qty'] ?? 0);
    $price = (float) ($item['price'] ?? 0);
    $vat_p = (float) ($item['vat'] ?? 0);
    $amount_excl = $qty * $price;
    $vat_amt = ($amount_excl * $vat_p) / 100;
    $amount_incl = (float) ($item['total'] ?? ($amount_excl + $vat_amt));
    $grand_total += $amount_incl;

    $h_r = 10;
    $pdf->MultiCell($w['no'], $h_r, $count++, 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['car'], $h_r, $item['item_name'] ?? '-', 1, 'L', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['service'], $h_r, $item['service_type'] ?? "Rental Without Driver", 1, 'L', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['period'], $h_r, ($item['period_from'] ?? "") . " to " . ($item['period_to'] ?? ""), 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['months'], $h_r, $item['months_days'] ?? 1, 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['qty'], $h_r, $item['qty'] ?? 0, 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['unit'], $h_r, number_format($price, 3), 1, 'R', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['excl'], $h_r, number_format($amount_excl, 3), 1, 'R', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['vat_p'], $h_r, $vat_p . '%', 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['vat_a'], $h_r, number_format($vat_amt, 3), 1, 'R', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['incl'], $h_r, number_format($amount_incl, 3), 1, 'R', 0, 1, '', '', true, 0, false, true, $h_r, 'M');
}

$pdf->SetFillColor(237, 28, 36);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 10);
$total_w_label = array_sum(array_slice(array_values($w), 0, 10));
$pdf->Cell($total_w_label, 10, 'NET TOTAL', 1, 0, 'R', 1);
$pdf->Cell($w['incl'], 10, number_format($grand_total, 3), 1, 1, 'R', 1);

// Notes section
$pdf->Ln(4);
$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, 'Note :', 0, 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);
$display_notes = !empty($custom_notes) ? $custom_notes : "We feel certain you will find our quotation meeting with your kind approval. If you require any further information, please feel free to contact us on 39000199";
$pdf->writeHTML($display_notes, true, false, true, false, 'L');

// --- START OF FINAL RENDERING BLOCKS ---

// 1. FINAL PASS: Determine last page and prepare signature
$total_pages = $pdf->getNumPages();
$pdf->setPage($total_pages);

// 2. Add signature block text
$pdf->SetY($pdf->GetY());

// Safety check: if we are too close to the bottom, start the signature on a new page
// Reduced threshold for Landscape to be VERY permissive (A4 L = 210mm total)
$sig_threshold = (strtoupper($orientation) == 'L') ? 22 : 35;
if ($pdf->GetY() > ($pdf->getPageHeight() - $sig_threshold)) {
    $pdf->AddPage();
}

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, 'Best Regards,', 0, 1);
$pdf->Ln(2);
$pdf->Cell(0, 5, 'AA CAR RENTAL CO. W.L.L.', 0, 1);
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, 'Thank you for your interest in,', 0, 1);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(0, 5, 'A.A.CAR RENTAL CO. W.L.L', 0, 1);

// 3. Last Page Seal & Signature (CUSTOM ONLY - Standard L/C/R is now in Footer)
if ($seal_last_pg === 'last_custom') {
    $img_w = 35;
    $page_w = $pdf->getPageWidth();
    $page_h = $pdf->getPageHeight();

    $x_final = $seal_last_x;
    $y_final = ($seal_last_y < 0) ? $page_h + $seal_last_y : $seal_last_y;
    
    // Safety Clamp
    $max_h = $page_h - 15;
    if ($y_final > $max_h) $y_final = $max_h;
    
    $y_pos = ($y_final < 0) ? $page_h + $y_final : $y_final;

    $seal_file = 'logos/seal_and_sig.png';
    if (!file_exists($seal_file)) {
        $seal_file = 'assets/img/logo/seal_and_sig.png';
    }

    if (file_exists($seal_file)) {
        $pdf->Image($seal_file, $x_final, $y_pos, $img_w, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
}
// --- END OF FINAL RENDERING ---

ob_end_clean();
$pdf->Output('Quotation_' . $quotation_no . '.pdf', 'I');
