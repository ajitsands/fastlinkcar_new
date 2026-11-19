<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ROOT_PATH . '/__db.php';
require_once ROOT_PATH . '/pdf/print_settings_helper.php';

class PrintFormatMasterController
{
    private $pdo;
    private $companyId;
    private $userId;

    public function __construct()
    {
        $this->pdo = getPDO();
        $this->companyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
        $this->userId = !empty($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 1;

        $action = $_POST['action'] ?? $_GET['action'] ?? null;
        if ($action === null) {
            $rawInput = file_get_contents('php://input');
            $json = json_decode($rawInput, true);
            if (is_array($json)) {
                $action = $json['action'] ?? null;
            }
        }

        if ($action === 'get_settings') {
            $this->getSettings();
        } elseif ($action === 'save_settings') {
            $this->saveSettings();
        } elseif ($action === 'reset_logo') {
            $this->resetLogo();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
    }

    private function getSettings()
    {
        try {
            $settings = getPrintSettings($this->pdo, $this->companyId);
            echo json_encode(['status' => 'success', 'data' => $settings]);
        } catch (Throwable $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function saveSettings()
    {
        try {
            $current = getPrintSettings($this->pdo, $this->companyId);

            $companyName    = trim($_POST['company_name'] ?? $current['company_name']);
            $companyNameAr  = trim($_POST['company_name_ar'] ?? '');
            $headerSubtitle = trim($_POST['header_subtitle'] ?? '');
            $headerAddress  = trim($_POST['header_address'] ?? '');
            $headerPhone    = trim($_POST['header_phone'] ?? '');
            $headerEmail    = trim($_POST['header_email'] ?? '');
            $headerWebsite  = trim($_POST['header_website'] ?? '');
            $showLogo       = !empty($_POST['show_logo']) ? 1 : 0;
            $logoWidth      = max(60, min(260, (int)($_POST['logo_width'] ?? 150)));
            $footerText     = trim($_POST['footer_text'] ?? '');
            $footerTextAr   = trim($_POST['footer_text_ar'] ?? '');
            $footerNote     = trim($_POST['footer_note'] ?? '');
            $showFooter     = !empty($_POST['show_footer']) ? 1 : 0;
            $accentColor    = trim($_POST['accent_color'] ?? '#1b3d94');
            if (!preg_match('/^#[0-9a-fA-F]{6}$/', $accentColor)) {
                $accentColor = '#1b3d94';
            }

            $headerLogo = trim($_POST['header_logo_choice'] ?? $current['header_logo']);
            if ($headerLogo === '') {
                $headerLogo = 'assets/img/logo_new/fastlinklogoblue.png';
            }

            // Handle optional custom logo upload
            if (!empty($_FILES['logo_file']['name']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION));
                $allowed = ['png', 'jpg', 'jpeg', 'webp'];
                if (!in_array($ext, $allowed, true)) {
                    echo json_encode(['status' => 'error', 'message' => 'Only PNG, JPG, JPEG, or WEBP logos are allowed.']);
                    return;
                }
                $uploadDir = ROOT_PATH . '/uploads/print_logos';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $fileName = 'print_logo_c' . $this->companyId . '_' . time() . '.' . $ext;
                $destPath = $uploadDir . '/' . $fileName;
                if (!move_uploaded_file($_FILES['logo_file']['tmp_name'], $destPath)) {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save uploaded logo.']);
                    return;
                }
                $headerLogo = 'uploads/print_logos/' . $fileName;
            }

            $sql = "INSERT INTO tbl_print_settings (
                        company_id, company_name, company_name_ar, header_subtitle,
                        header_address, header_phone, header_email, header_website,
                        header_logo, show_logo, logo_width,
                        footer_text, footer_text_ar, footer_note, show_footer,
                        accent_color, updated_by
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                    )
                    ON DUPLICATE KEY UPDATE
                        company_name    = VALUES(company_name),
                        company_name_ar = VALUES(company_name_ar),
                        header_subtitle = VALUES(header_subtitle),
                        header_address  = VALUES(header_address),
                        header_phone    = VALUES(header_phone),
                        header_email    = VALUES(header_email),
                        header_website  = VALUES(header_website),
                        header_logo     = VALUES(header_logo),
                        show_logo       = VALUES(show_logo),
                        logo_width      = VALUES(logo_width),
                        footer_text     = VALUES(footer_text),
                        footer_text_ar  = VALUES(footer_text_ar),
                        footer_note     = VALUES(footer_note),
                        show_footer     = VALUES(show_footer),
                        accent_color    = VALUES(accent_color),
                        updated_by      = VALUES(updated_by)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $this->companyId, $companyName, $companyNameAr, $headerSubtitle,
                $headerAddress, $headerPhone, $headerEmail, $headerWebsite,
                $headerLogo, $showLogo, $logoWidth,
                $footerText, $footerTextAr, $footerNote, $showFooter,
                $accentColor, $this->userId
            ]);

            $updated = getPrintSettings($this->pdo, $this->companyId);
            echo json_encode([
                'status'  => 'success',
                'message' => 'Print header and footer settings saved successfully.',
                'data'    => $updated
            ]);
        } catch (Throwable $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function resetLogo()
    {
        try {
            $defaultLogo = 'assets/img/logo_new/fastlinklogoblue.png';
            $stmt = $this->pdo->prepare("UPDATE tbl_print_settings SET header_logo = ?, updated_by = ? WHERE company_id = ?");
            $stmt->execute([$defaultLogo, $this->userId, $this->companyId]);

            $updated = getPrintSettings($this->pdo, $this->companyId);
            echo json_encode([
                'status'  => 'success',
                'message' => 'Logo reset to Fast Link Blue.',
                'data'    => $updated
            ]);
        } catch (Throwable $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

new PrintFormatMasterController();
