<?php
// controller/reports/CustomerBalanceController.php
require_once ROOT_PATH . '/__db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_balances') {
    $pdo = getPDO();

    try {
        // 1. Load all customers keyed by customer_id and ids
        $stmtCust = $pdo->query("
            SELECT ids, customer_id, customer_name, customer_mobile, customer_cr_cpr, customer_email, nationality AS customer_nationality
            FROM customer_details
            ORDER BY customer_name ASC
        ");
        $customersByKey = [];
        $custAlias = [];
        foreach ($stmtCust->fetchAll(PDO::FETCH_ASSOC) as $c) {
            $cid = (string)($c['customer_id'] ?? '');
            if ($cid === '') {
                continue;
            }
            $customersByKey[$cid] = [
                'customer_id'          => $cid,
                'customer_name'        => $c['customer_name'] ?? '',
                'customer_mobile'      => $c['customer_mobile'] ?? '',
                'customer_cr_cpr'      => $c['customer_cr_cpr'] ?? '',
                'customer_email'       => $c['customer_email'] ?? '',
                'customer_nationality' => $c['customer_nationality'] ?? '',
                'total_debit'          => 0.0,
                'total_credit'         => 0.0,
                'balance'              => 0.0,
            ];
            $custAlias[$cid] = $cid;
            if (!empty($c['ids'])) {
                $custAlias[(string)$c['ids']] = $cid;
            }
        }

        // 2. Aggregate ledger debits & valid credits per customer and track contracts with debits
        $stmtLed = $pdo->query("
            SELECT
                customer_code,
                contract_ids,
                agreement_no,
                debit,
                CASE WHEN COALESCE(cheque_status, '') = 'Bounced' THEN 0 ELSE credit END AS valid_credit
            FROM tbl_customer_ledger
        ");
        $contractsWithDebit = [];
        foreach ($stmtLed->fetchAll(PDO::FETCH_ASSOC) as $l) {
            $rawCode = (string)($l['customer_code'] ?? '');
            $custKey = $custAlias[$rawCode] ?? '';
            if ($custKey === '' || !isset($customersByKey[$custKey])) {
                continue;
            }
            $deb = (float)($l['debit'] ?? 0);
            $cred = (float)($l['valid_credit'] ?? 0);
            $customersByKey[$custKey]['total_debit'] += $deb;
            $customersByKey[$custKey]['total_credit'] += $cred;

            if ($deb > 0) {
                if (!empty($l['contract_ids'])) {
                    $contractsWithDebit['id_' . $l['contract_ids']] = true;
                }
                if (!empty($l['agreement_no'])) {
                    $contractsWithDebit['agr_' . $l['agreement_no']] = true;
                }
            }
        }

        // 3. Include closed / returned / active contracts that have no debit posted in tbl_customer_ledger yet
        $stmtCon = $pdo->query("
            SELECT ids, agreement_no, customer_code, agreement_status, contract_details_json
            FROM tbl_vehicle_rentout_contracts
            WHERE LOWER(COALESCE(agreement_status, '')) NOT IN ('cancelled', 'canceled', 'void')
        ");
        foreach ($stmtCon->fetchAll(PDO::FETCH_ASSOC) as $ct) {
            $rawCode = (string)($ct['customer_code'] ?? '');
            $custKey = $custAlias[$rawCode] ?? '';
            if ($custKey === '' || !isset($customersByKey[$custKey])) {
                continue;
            }
            $hasDebit = !empty($contractsWithDebit['id_' . $ct['ids']])
                || (!empty($ct['agreement_no']) && !empty($contractsWithDebit['agr_' . $ct['agreement_no']]));
            if ($hasDebit) {
                continue;
            }

            $cdj = !empty($ct['contract_details_json']) ? (json_decode($ct['contract_details_json'], true) ?: []) : [];
            $contractAmt = (float)($cdj['total_amount'] ?? ($cdj['total_amt'] ?? ($cdj['grand_total'] ?? 0)));
            if ($contractAmt > 0) {
                $customersByKey[$custKey]['total_debit'] += $contractAmt;
            }
        }

        // 4. Filter & format
        $results = [];
        foreach ($customersByKey as $row) {
            $row['total_debit'] = round($row['total_debit'], 3);
            $row['total_credit'] = round($row['total_credit'], 3);
            $row['balance'] = round($row['total_debit'] - $row['total_credit'], 3);
            if (abs($row['balance']) > 0.0001 || $row['total_debit'] > 0 || $row['total_credit'] > 0) {
                $results[] = $row;
            }
        }

        echo json_encode(['status' => 'success', 'data' => $results]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Database Error: " . $e->getMessage()]);
        exit;
    }
}

// Initial page load
include 'view/customer_balance_report.php';
?>
