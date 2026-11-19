<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once ROOT_PATH . '/__db.php';

class CustomerAccountController
{
    private $pdo;
    private $companyId;
    private $userId;

    public function __construct()
    {
        $this->pdo = getPDO();
        $this->companyId = (int)($_SESSION['company_id'] ?? 1);
        $this->userId = (int)($_SESSION['user_id'] ?? 1);
    }

    public function handle()
    {
        $raw = file_get_contents('php://input');
        $json = $raw ? json_decode($raw, true) : null;
        $req = is_array($json) ? $json : array_merge($_GET, $_POST);
        $action = $req['action'] ?? 'list';

        try {
            switch ($action) {
                case 'list':
                    $activeOnly = !empty($req['active_only']);
                    $sql = "SELECT ids, account_name, status, company_id, created_at FROM tbl_customer_accounts WHERE 1=1";
                    $params = [];
                    if ($activeOnly) {
                        $sql .= " AND status = 'Active'";
                    }
                    $sql .= " ORDER BY account_name ASC, ids DESC";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute($params);
                    echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
                    break;

                case 'save':
                    $id = !empty($req['ids']) ? (int)$req['ids'] : 0;
                    $accountName = trim((string)($req['account_name'] ?? ''));
                    $status = ($req['status'] ?? 'Active') === 'Inactive' ? 'Inactive' : 'Active';

                    if ($accountName === '') {
                        echo json_encode(['status' => false, 'message' => 'Account Name is required.']);
                        return;
                    }

                    if ($id > 0) {
                        $stmt = $this->pdo->prepare("UPDATE tbl_customer_accounts SET account_name = ?, status = ? WHERE ids = ?");
                        $stmt->execute([$accountName, $status, $id]);
                        echo json_encode(['status' => true, 'message' => 'Customer Account updated successfully.']);
                    } else {
                        $stmt = $this->pdo->prepare("INSERT INTO tbl_customer_accounts (account_name, status, company_id, created_by) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$accountName, $status, $this->companyId, $this->userId]);
                        echo json_encode(['status' => true, 'message' => 'Customer Account added successfully.', 'id' => $this->pdo->lastInsertId()]);
                    }
                    break;

                case 'toggle_status':
                    $id = (int)($req['ids'] ?? 0);
                    $status = ($req['status'] ?? 'Active') === 'Inactive' ? 'Inactive' : 'Active';
                    if ($id <= 0) {
                        echo json_encode(['status' => false, 'message' => 'Invalid account ID.']);
                        return;
                    }
                    $stmt = $this->pdo->prepare("UPDATE tbl_customer_accounts SET status = ? WHERE ids = ?");
                    $stmt->execute([$status, $id]);
                    echo json_encode(['status' => true, 'message' => "Account status updated to {$status}."]);
                    break;

                default:
                    echo json_encode(['status' => false, 'message' => 'Unknown action.']);
            }
        } catch (Throwable $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}

$ctrl = new CustomerAccountController();
$ctrl->handle();
