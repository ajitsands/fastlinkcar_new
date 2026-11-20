<?php

class VehicleStatusHelper
{
    private static $cachedMap = null;

    private static function getPdo()
    {
        $host = $_ENV['DB_HOST'] ?? (defined('DB_HOST') ? DB_HOST : '127.0.0.1');
        $db   = $_ENV['DB_NAME'] ?? (defined('DB_NAME') ? DB_NAME : 'db_fastlink_carrental');
        $user = $_ENV['DB_USER'] ?? (defined('DB_USER') ? DB_USER : 'root');
        $pass = $_ENV['DB_PASS'] ?? (defined('DB_PASS') ? DB_PASS : '');
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    }

    public static function normalizeKey($status)
    {
        $k = strtolower(preg_replace('/\s+/', '', (string)$status));
        if ($k === 'active') return 'available';
        if ($k === 'parked') return 'parking';
        if ($k === 'rented' || $k === 'onrent') return 'rentout';
        if ($k === 'maintence' || $k === 'workshop') return 'maintenance';
        if ($k === 'inactive') return 'deactivated';
        return $k;
    }

    public static function getContrastTextColor($hex)
    {
        $hex = ltrim((string)$hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        if (strlen($hex) !== 6) return '#ffffff';
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $lum = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        return $lum > 0.62 ? '#1e293b' : '#ffffff';
    }

    public static function ensureTableAndDefaults($pdo = null)
    {
        if ($pdo === null) {
            $pdo = self::getPdo();
        }
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `tbl_vehicle_status_colors` (
              `ids` int(11) NOT NULL AUTO_INCREMENT,
              `status_name` varchar(80) NOT NULL,
              `status_key` varchar(80) NOT NULL,
              `badge_color` varchar(20) NOT NULL DEFAULT '#28c76f',
              `text_color` varchar(20) NOT NULL DEFAULT '#ffffff',
              `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`ids`),
              UNIQUE KEY `uq_status_key` (`status_key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        $defaults = [
            ['Available',   'available',   '#28c76f', '#ffffff'],
            ['Parking',     'parking',     '#00cfe8', '#ffffff'],
            ['Rentout',     'rentout',     '#ea5455', '#ffffff'],
            ['Staff Use',   'staffuse',    '#ff4c51', '#ffffff'],
            ['Maintenance', 'maintenance', '#ff9f43', '#1e293b'],
            ['Blocked',     'blocked',     '#4b4b4b', '#ffffff'],
            ['Sale Out',    'saleout',     '#1b3d94', '#ffffff'],
            ['Deactivated', 'deactivated', '#82868b', '#ffffff'],
        ];

        $stmtIns = $pdo->prepare("INSERT IGNORE INTO tbl_vehicle_status_colors (status_name, status_key, badge_color, text_color) VALUES (?, ?, ?, ?)");
        foreach ($defaults as $d) {
            $stmtIns->execute($d);
        }

        // Also ensure any distinct vehicle_status in tbl_vehicles has an entry
        try {
            $rows = $pdo->query("SELECT DISTINCT vehicle_status FROM tbl_vehicles WHERE vehicle_status IS NOT NULL AND TRIM(vehicle_status) <> ''")->fetchAll(PDO::FETCH_COLUMN);
            foreach ($rows as $st) {
                $key = self::normalizeKey($st);
                if ($key !== '') {
                    $stmtIns->execute([trim($st), $key, '#6c757d', '#ffffff']);
                }
            }
        } catch (Exception $e) {}
    }

    public static function getStatusColorMap($forceRefresh = false)
    {
        if (self::$cachedMap !== null && !$forceRefresh) {
            return self::$cachedMap;
        }
        try {
            $pdo = self::getPdo();
            self::ensureTableAndDefaults($pdo);
            $rows = $pdo->query("SELECT ids, status_name, status_key, badge_color, text_color FROM tbl_vehicle_status_colors ORDER BY ids ASC")->fetchAll();
            $map = [];
            foreach ($rows as $r) {
                $map[$r['status_key']] = [
                    'ids'         => (int)$r['ids'],
                    'status_name' => $r['status_name'],
                    'status_key'  => $r['status_key'],
                    'badge_color' => $r['badge_color'],
                    'text_color'  => $r['text_color'],
                ];
            }
            self::$cachedMap = $map;
            return $map;
        } catch (Exception $e) {
            return [];
        }
    }

    public static function getBadgeStyle($status)
    {
        $map = self::getStatusColorMap();
        $key = self::normalizeKey($status);
        if (isset($map[$key])) {
            $bg = htmlspecialchars($map[$key]['badge_color'], ENT_QUOTES, 'UTF-8');
            $fg = htmlspecialchars($map[$key]['text_color'], ENT_QUOTES, 'UTF-8');
            return "background-color: {$bg} !important; color: {$fg} !important;";
        }
        return '';
    }
}
