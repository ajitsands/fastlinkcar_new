<?php

class PermissionHelper
{
    /**
     * Ensure permission database tables exist
     */
    public static function ensureTablesExist()
    {
        try {
            $db = new CommonPDOModel();
            $pdo = $db->varDBPDO;
            if (!$pdo) return;

            $sql1 = "CREATE TABLE IF NOT EXISTS `tbl_permissions` (
                `permission_id` INT(11) NOT NULL AUTO_INCREMENT,
                `permission_name` VARCHAR(200) NOT NULL,
                `permission_key` VARCHAR(100) NOT NULL,
                `module_group` VARCHAR(100) DEFAULT 'General',
                `element_type` VARCHAR(50) DEFAULT 'submenu',
                `status` VARCHAR(20) DEFAULT 'Active',
                PRIMARY KEY (`permission_id`),
                UNIQUE KEY `uniq_perm_key` (`permission_key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $pdo->exec($sql1);

            $sql2 = "CREATE TABLE IF NOT EXISTS `tbl_role_permissions` (
                `ids` INT(11) NOT NULL AUTO_INCREMENT,
                `role_id` INT(11) NOT NULL,
                `permission_id` INT(11) NOT NULL,
                `status` VARCHAR(20) NOT NULL DEFAULT 'Granted',
                `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`ids`),
                UNIQUE KEY `uniq_role_perm` (`role_id`, `permission_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $pdo->exec($sql2);

            // Guarantee columns exist on pre-existing tbl_role_permissions tables
            try {
                $cols = $pdo->query("SHOW COLUMNS FROM tbl_role_permissions")->fetchAll(PDO::FETCH_COLUMN);
                if (!in_array('status', $cols)) {
                    $pdo->exec("ALTER TABLE `tbl_role_permissions` ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'Granted'");
                }
                if (!in_array('updated_date', $cols)) {
                    $pdo->exec("ALTER TABLE `tbl_role_permissions` ADD COLUMN `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP");
                }
            } catch (Exception $ex) {}

            $sql3 = "CREATE TABLE IF NOT EXISTS `tbl_user_permissions` (
                `ids` INT(11) NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) NOT NULL,
                `permission_id` INT(11) NOT NULL,
                `status` VARCHAR(20) NOT NULL DEFAULT 'Granted',
                `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`ids`),
                UNIQUE KEY `uniq_user_perm` (`user_id`, `permission_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $pdo->exec($sql3);
        } catch (Exception $e) {
            // Log or ignore
        }
    }

    /**
     * Load effective user permissions into PHP session
     */
    public static function loadUserPermissionsIntoSession($userId, $roleId, $roleName = '')
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        self::ensureTablesExist();

        $roleIds = array_filter(array_map('intval', explode(',', strval($roleId))));
        $roleNames = array_map('trim', explode(',', strval($roleName)));

        $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) ||
            in_array(3, $roleIds) ||
            in_array('Super Admin', $roleNames);

        if ($isSuperAdmin) {
            $_SESSION['is_super_admin'] = true;
            $_SESSION['user_permissions'] = ['*'];
            return ['*'];
        }

        $effectivePermissions = [];

        try {
            $db = new CommonPDOModel();
            $pdo = $db->varDBPDO;
            if (!$pdo) return [];

            // 1. Fetch Role permissions (Default permissions granted to the Role(s))
            $rolePermMap = [];
            if (!empty($roleIds)) {
                $placeholders = implode(',', array_fill(0, count($roleIds), '?'));
                $stmt = $pdo->prepare("
                    SELECT p.permission_id, p.permission_key, rp.status 
                    FROM tbl_role_permissions rp
                    JOIN tbl_permissions p ON p.permission_id = rp.permission_id
                    WHERE rp.role_id IN ($placeholders) AND p.status = 'Active'
                ");
                $stmt->execute($roleIds);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $pId = intval($row['permission_id']);
                    $currentStatus = $rolePermMap[$pId]['status'] ?? 'Revoked';
                    if ($row['status'] === 'Granted') {
                        $currentStatus = 'Granted';
                    }
                    $rolePermMap[$pId] = [
                        'key' => $row['permission_key'],
                        'status' => $currentStatus
                    ];
                }
            }

            // 2. Fetch all active permissions to evaluate effective status
            $allPerms = $pdo->query("SELECT permission_id, permission_key FROM tbl_permissions WHERE status = 'Active'")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($allPerms as $perm) {
                $pId = intval($perm['permission_id']);
                $pKey = $perm['permission_key'];

                // Role default (default to Revoked if not set in any role)
                $effectiveStatus = $rolePermMap[$pId]['status'] ?? 'Revoked';

                if ($effectiveStatus === 'Granted' && !empty($pKey)) {
                    $effectivePermissions[] = $pKey;
                }
            }
        } catch (Exception $e) {
            // Handle error
        }

        $_SESSION['user_permissions'] = $effectivePermissions;
        return $effectivePermissions;
    }

    /**
     * Check if logged in user has specific permission
     */
    public static function hasPermission($permissionKey)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $perms = $_SESSION['user_permissions'] ?? null;

        // If session not loaded yet, reload
        if ($perms === null && !empty($_SESSION['user_id'])) {
            $perms = self::loadUserPermissionsIntoSession(
                $_SESSION['user_id'],
                $_SESSION['user_role_id'] ?? 0,
                $_SESSION['user_role_name'] ?? ''
            );
        }

        if (!is_array($perms)) return false;

        // Super Admin has all permissions
        if (in_array('*', $perms)) return true;

        return in_array($permissionKey, $perms);
    }

    /**
     * Guard API request - abort with 403 if unauthorized
     */
    public static function checkPermissionOrDie($permissionKey)
    {
        if (!self::hasPermission($permissionKey)) {
            header('Content-Type: application/json', true, 403);
            echo json_encode([
                'status' => false,
                'message' => 'Permission Denied: You do not have permission to execute this action (' . $permissionKey . ').'
            ]);
            exit;
        }
    }
}

function has_permission($permissionKey) {
    return PermissionHelper::hasPermission($permissionKey);
}
