<?php

define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/../envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/../envfiles');
$dotenv->load();

require_once 'vendor/autoload.php';

// Database configurations
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'sandsl23_aa_car_rental');

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
$page_break_threshold = isset($params['page_break_threshold']) ? (float) $params['page_break_threshold'] : 30;

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
            ['item_name' => 'HYUNDAI ACCENT', 'service_name' => 'Rental Without Driver', 'period_from' => '2026-03-01T16:21', 'period_to' => '2026-03-28T16:21', 'duration' => '27', 'qty' => 1, 'price' => 12, 'vat' => 10, 'total' => 356.400, 'item_model_pic' => 'default.jpg'],
            ['item_name' => 'KIA PEGAS', 'service_name' => 'Rental With Driver', 'period_from' => '2026-03-01T16:21', 'period_to' => '2026-06-30T16:21', 'duration' => '5', 'qty' => 1, 'price' => 10, 'vat' => 0, 'total' => 50.000, 'item_model_pic' => 'default.jpg']
        ])
    ];
}

$quotation_no = $data['quotation_no'];
$customer_address = $data['customer_address'];
$quotation_date = date('d-m-Y', strtotime($data['quotation_date']));
$customer_name = $data['customer_name'];
$customer_email = $data['customer_email'];
$attention = $data['attention'] ?? '';
$introduction = !empty($data['introduction']) ? $data['introduction'] : "With reference to your inquiry regarding the rental of Vehicles, we are pleased to quote our best prices as mention below:";
$custom_notes = !empty($data['terms']) ? $data['terms'] : ($params['notes'] ?? "");
$items = json_decode($data['items'], true);

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
$pdf->SetTitle('Quotation V2 ' . $quotation_no);
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
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($colWidth - 15, 5, $customer_address, 0, 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(20);
$pdf->SetFont('dejavusans', '', 9);
$html_info = '
<table border="0" cellpadding="0">
    <tr>
        <td width="50"><b>Attn :</b></td>
        <td width="350">' . $attention . '</td>
    </tr>
    <tr>
        <td width="50" style="padding-top:10px;"><b>Email :</b></td>
        <td width="350" style="color:#0000FF; padding-top:10px;">' . $customer_email . '</td>
    </tr>
</table>';
$pdf->writeHTMLCell($colWidth, 0, 20, $pdf->GetY(), $html_info, 0, 1, 0, true, 'L', true);

// Right Info (Date/No)
$pdf->SetXY(20 + $colWidth, $startY);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($colWidth - 45, 6, 'Date:', 0, 0, 'R');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(45, 6, $quotation_date, 0, 1, 'R');
$pdf->SetX(20 + $colWidth);
$pdf->SetTextColor(0, 0, 255);
$pdf->Cell($colWidth - 45, 6, 'Qtn. No:', 0, 0, 'R');
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(45, 6, $quotation_no, 0, 1, 'R');

$pdf->Ln(8);
$pdf->SetFont('helvetica', '', 10);
$pdf->SetMargins(21, 28, 15);
$pdf->writeHTML($introduction, true, false, true, false, 'L');

// HTML-based Table
$pdf->SetMargins(15, 28, 15);
$pdf->Ln(5);

$table_html = '
<style>
    table.items-table {
        border-collapse: collapse;
        width: 95%;
        font-size: ' . $font_size_table . 'pt;
    }
    table.items-table th {
        background-color: #ed1c1c;
        color: #ffffff;
        border: 1px solid #ffffff;
        font-weight: bold;
        text-align: center;
        padding: 8px 5px;
    }
    table.items-table td {
        border: 1px solid #dcdcdc;
        padding: 8px 5px;
        vertical-align: middle;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
</style>
<table class="items-table">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="17%">Type of Car</th>
            <th width="12%">Service Type</th>
            <th width="18%">Period</th>
            <th width="8%">Duration(Months/Days)</th>
            <th width="5%">Qty</th>
            <th width="9%">Unit Price (BHD)</th>
            <th width="10%">Excl. VAT (BHD)</th>
            <th width="4%">VAT %</th>
            <th width="5%">VAT Amt</th>
            <th width="8%">Total (BHD)</th>
        </tr>
    </thead>
    <tbody>';

$count = 1;
$grand_total = 0;
$quotation_images = [];
foreach ($items as $item) {
    $qty = (float) ($item['qty'] ?? 0);
    $price = (float) ($item['price'] ?? 0);
    $vat_p = (float) ($item['vat'] ?? 0);
    $amount_excl = (float) ($item['total_excl'] ?? ($qty * $price));
    $vat_amt = ($amount_excl * $vat_p) / 100;
    $amount_incl = (float) ($item['total'] ?? ($amount_excl + $vat_amt));
    $grand_total += $amount_incl;

    if (!empty($item['item_model_pic'])) {
       $img_file = 'https://aacar.sandslab.com/httpdocs/images/vehicle_model_images/'.$item['item_model_pic'];
       if (!in_array($img_file, $quotation_images)) {
           $quotation_images[] = $img_file;
       }
    }

    $table_html .= '
        <tr>
            <td width="4%" class="text-center">' . $count++ . '</td>
            <td width="17%" class="text-left">' . ($item['item_name'] ?? '-') . '</td>
            <td width="12%" class="text-left">' . ($item['service_name'] ?? ($item['service_type'] ?? '-')) . '</td>
            <td width="18%" class="text-center">' . date('d-m-y', strtotime($item['period_from'])) . ' to ' . date('d-m-y', strtotime($item['period_to'])) . '</td>
            <td width="8%" class="text-center">' . ($item['duration'] ?? ($item['months_days'] ?? 1)) . '</td>
            <td width="5%" class="text-center">' . $qty . '</td>
            <td width="9%" class="text-right">' . number_format($price, 3) . '</td>
            <td width="10%" class="text-right">' . number_format($amount_excl, 3) . '</td>
            <td width="4%" class="text-center">' . $vat_p . '%</td>
            <td width="5%" class="text-right">' . number_format($vat_amt, 3) . '</td>
            <td width="8%" class="text-right">' . number_format($amount_incl, 3) . '</td>
        </tr>';
}

$table_html .= '
        <tr style="background-color: #ed1c1c; color: #ffffff; font-weight: bold;">
            <td colspan="10" class="text-right" style="padding: 10px;">NET TOTAL (BHD)</td>
            <td class="text-right" style="padding: 10px;">' . number_format($grand_total, 3) . '</td>
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($table_html, true, false, true, false, '');

// Notes section
$pdf->Ln(4);
$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, 'Note :', 0, 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);
$display_notes = !empty($custom_notes) ? $custom_notes : "We feel certain you will find our quotation meeting with your kind approval. If you require any further information, please feel free to contact us on 39000199";
$pdf->writeHTML($display_notes, true, false, true, false, 'L');

// Final rendering pass
$total_pages = $pdf->getNumPages();
$pdf->setPage($total_pages);

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

// Custom Seal (Standard Seal is in Footer)
if ($seal_last_pg === 'last_custom') {
    $img_w = 35;
    $page_w = $pdf->getPageWidth();
    $page_h = $pdf->getPageHeight();
    $y_final = ($seal_last_y < 0) ? $page_h + $seal_last_y : $seal_last_y;
    $max_h = $page_h - 15;
    if ($y_final > $max_h) $y_final = $max_h;
    
    $y_pos = $y_final;
    $seal_file = 'logos/seal_and_sig.png';
    if (!file_exists($seal_file)) $seal_file = '../assets/img/logo/seal_and_sig.png';

    if (file_exists($seal_file)) {
        $pdf->Image($seal_file, $seal_last_x, $y_pos, $img_w, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
}

// Render Images on a new page if needed
if (!empty($quotation_images)) {
    // Only add a new page if we are too far down the current page.
    // This prevents leaving a nearly blank page (e.g. if only "Best Regards" is on it).
    if ($pdf->GetY() > 70) {
        $pdf->AddPage();
    } else {
        $pdf->Ln(10);
    }
    
    $pdf->SetFont('dejavusans', 'B', 12);
    $pdf->Cell(0, 10, 'Vehicle Images / صور المركبة', 0, 1, 'C');
    $pdf->SetFont('dejavusans', '', 9);

    $html_images = '<table cellpadding="5" border="0" width="100%">';
    $col = 0;
    
    foreach ($quotation_images as $idx => $img_url) {
        if ($col == 0) {
            $html_images .= '<tr>';
        }
        
        $html_images .= '<td width="50%" align="center">';
        $html_images .= '<img src="' . htmlspecialchars($img_url) . '" width="250" height="180">';
        $html_images .= '</td>';
        
        $col++;
        if ($col == 2) {
            $html_images .= '</tr>';
            $col = 0;
        }
    }
    
    if ($col == 1) {
        $html_images .= '<td width="50%"></td></tr>';
    }
    $html_images .= '</table>';
    
    $pdf->writeHTML($html_images, true, false, true, false, '');
}

ob_end_clean();
$pdf->Output('Quotation_V2_' . $quotation_no . '.pdf', 'I');
