<?php
/**
 * Shared Print Settings Helper
 * Loads customizable Header, Footer, and Logo settings from tbl_print_settings.
 */

if (!function_exists('getPrintSettings')) {
    function getPrintSettings($conn = null, $companyId = null)
    {
        if ($companyId === null) {
            $companyId = !empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1;
        } else {
            $companyId = (int)$companyId;
        }

        $defaults = [
            'company_id'      => $companyId,
            'company_name'    => 'FAST LINK',
            'company_name_ar' => '',
            'header_subtitle' => 'Car Rental & Fleet Solutions',
            'header_address'  => 'Kingdom of Bahrain',
            'header_phone'    => '',
            'header_email'    => '',
            'header_website'  => '',
            'header_logo'     => 'assets/img/logo_new/fastlinklogoblue.png',
            'show_logo'       => 1,
            'logo_width'      => 150,
            'footer_text'     => 'Thank you for choosing Fast Link Car Rental.',
            'footer_text_ar'  => '',
            'footer_note'     => 'This is a computer-generated document.',
            'show_footer'     => 1,
            'accent_color'    => '#1b3d94',
        ];

        $row = null;

        try {
            if ($conn instanceof mysqli) {
                $stmt = @$conn->prepare("SELECT * FROM tbl_print_settings WHERE company_id = ? LIMIT 1");
                if ($stmt) {
                    $stmt->bind_param('i', $companyId);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    if ($res) {
                        $row = $res->fetch_assoc();
                    }
                    $stmt->close();
                }
            } elseif ($conn instanceof PDO) {
                $stmt = $conn->prepare("SELECT * FROM tbl_print_settings WHERE company_id = ? LIMIT 1");
                $stmt->execute([$companyId]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $dbFile = dirname(__DIR__) . '/__db.php';
                if (file_exists($dbFile)) {
                    require_once $dbFile;
                    if (function_exists('getPDO')) {
                        $pdo = getPDO();
                        $stmt = $pdo->prepare("SELECT * FROM tbl_print_settings WHERE company_id = ? LIMIT 1");
                        $stmt->execute([$companyId]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                }
            }
        } catch (Throwable $e) {
            // Fall back to defaults cleanly if table is unavailable
        }

        $settings = $row ? array_merge($defaults, $row) : $defaults;

        if (empty($settings['header_logo'])) {
            $settings['header_logo'] = 'assets/img/logo_new/fastlinklogoblue.png';
        }
        if (empty($settings['accent_color'])) {
            $settings['accent_color'] = '#1b3d94';
        }

        $rootDir = dirname(__DIR__);
        $relLogo = ltrim(str_replace('\\', '/', $settings['header_logo']), '/');
        $absLogo = $rootDir . '/' . $relLogo;

        if (!file_exists($absLogo)) {
            $relLogo = 'assets/img/logo_new/fastlinklogoblue.png';
            $absLogo = $rootDir . '/' . $relLogo;
        }

        $settings['logo_rel_path'] = $relLogo;
        $settings['logo_abs_path'] = file_exists($absLogo) ? $absLogo : '';
        $settings['logo_web_path'] = '../' . $relLogo;
        $settings['logo_base64']   = ($settings['logo_abs_path'] !== '')
            ? base64_encode(file_get_contents($settings['logo_abs_path']))
            : '';

        // Parse hex accent_color into RGB array [r, g, b] for TCPDF
        $hex = ltrim($settings['accent_color'], '#');
        if (strlen($hex) === 6 && ctype_xdigit($hex)) {
            $settings['accent_rgb'] = [
                hexdec(substr($hex, 0, 2)),
                hexdec(substr($hex, 2, 2)),
                hexdec(substr($hex, 4, 2)),
            ];
        } else {
            $settings['accent_rgb'] = [27, 61, 148];
        }

        return $settings;
    }
}

if (!function_exists('buildPrintContactLine')) {
    function buildPrintContactLine(array $settings)
    {
        $parts = [];
        if (!empty($settings['header_address'])) {
            $parts[] = $settings['header_address'];
        }
        if (!empty($settings['header_phone'])) {
            $parts[] = 'Tel: ' . $settings['header_phone'];
        }
        if (!empty($settings['header_email'])) {
            $parts[] = $settings['header_email'];
        }
        if (!empty($settings['header_website'])) {
            $parts[] = $settings['header_website'];
        }
        return implode(' | ', $parts);
    }
}

if (!function_exists('renderPrintHeaderHtml')) {
    function renderPrintHeaderHtml(array $settings, $docTitle = '', $badgeText = '', $subMeta = '')
    {
        $accent = htmlspecialchars($settings['accent_color'] ?? '#1b3d94');
        $companyName = htmlspecialchars($settings['company_name'] ?? 'FAST LINK');
        $companyNameAr = htmlspecialchars($settings['company_name_ar'] ?? '');
        $subtitle = htmlspecialchars($settings['header_subtitle'] ?? '');
        $contact = htmlspecialchars(buildPrintContactLine($settings));
        $logoWidth = max(60, min(260, (int)($settings['logo_width'] ?? 150)));

        $logoHtml = '';
        if (!empty($settings['show_logo']) && !empty($settings['logo_base64'])) {
            $logoHtml = '<img src="data:image/png;base64,' . $settings['logo_base64'] . '" alt="' . $companyName . '" style="max-height: 64px; max-width: ' . $logoWidth . 'px; width: auto; object-fit: contain;">';
        }

        $html = '<div class="report-header d-flex justify-content-between align-items-center" style="border-bottom: 2px solid ' . $accent . '; padding-bottom: 14px; margin-bottom: 20px;">';
        $html .= '<div class="d-flex align-items-center gap-3">';
        if ($logoHtml !== '') {
            $html .= '<div>' . $logoHtml . '</div>';
        }
        $html .= '<div>';
        $html .= '<h3 class="fw-bold mb-0" style="color: ' . $accent . ';">' . $companyName . ($companyNameAr !== '' ? ' <span style="font-size: 0.9em;">' . $companyNameAr . '</span>' : '') . '</h3>';
        if ($subtitle !== '') {
            $html .= '<div class="text-muted small fw-medium">' . $subtitle . '</div>';
        }
        if ($contact !== '') {
            $html .= '<div class="text-muted" style="font-size: 11px;">' . $contact . '</div>';
        }
        $html .= '</div></div>';

        $html .= '<div class="text-end">';
        if ($docTitle !== '') {
            $html .= '<div class="fw-bold text-uppercase" style="color: ' . $accent . '; font-size: 13px; letter-spacing: 0.5px;">' . htmlspecialchars($docTitle) . '</div>';
        }
        if ($badgeText !== '') {
            $html .= '<span class="badge fs-6 my-1" style="background-color: ' . $accent . ';">' . htmlspecialchars($badgeText) . '</span>';
        }
        if ($subMeta !== '') {
            $html .= '<div class="text-muted small">' . htmlspecialchars($subMeta) . '</div>';
        }
        $html .= '</div></div>';

        return $html;
    }
}

if (!function_exists('renderPrintFooterHtml')) {
    function renderPrintFooterHtml(array $settings)
    {
        if (empty($settings['show_footer'])) {
            return '';
        }
        $accent = htmlspecialchars($settings['accent_color'] ?? '#1b3d94');
        $footerText = htmlspecialchars($settings['footer_text'] ?? '');
        $footerTextAr = htmlspecialchars($settings['footer_text_ar'] ?? '');
        $footerNote = htmlspecialchars($settings['footer_note'] ?? '');

        $html = '<div class="report-footer mt-4 pt-2 text-center" style="border-top: 1px solid #d0d7e5; font-size: 11px; color: #555;">';
        if ($footerText !== '') {
            $html .= '<div class="fw-semibold" style="color: ' . $accent . ';">' . $footerText . '</div>';
        }
        if ($footerTextAr !== '') {
            $html .= '<div style="color: ' . $accent . ';">' . $footerTextAr . '</div>';
        }
        if ($footerNote !== '') {
            $html .= '<div class="text-muted mt-1">' . $footerNote . '</div>';
        }
        $html .= '</div>';

        return $html;
    }
}
