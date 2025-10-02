<?php
require('../dbconn.php');

header('Content-Type: application/json');

// Fetch all orders first
$query = "SELECT *, (qty * bo_price) AS total 
          FROM backorders_tbl ORDER BY order_date DESC";

$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orderDate = new DateTime($row['order_date']);
    $eta1 = !empty($row['eta_1']) ? new DateTime($row['eta_1']) : null;

    $aging = null;
    $finalEta = null;
    $eta2 = null;
    $eta3 = null;
    $rowClass = ""; // default = no special class

    if ($eta1) {
        $today = new DateTime();

        if ($today <= $eta1) {
            // Not overdue, use eta_1
            $finalEta = $eta1;
        } else {
            // Overdue: add 15 days = eta_2
            $eta2 = (clone $eta1)->modify('+15 days');
            $finalEta = $eta2;

            if (empty($row['eta_2'])) {
                $update = "UPDATE backorders_tbl 
                           SET eta_2 = '" . $eta2->format('Y-m-d') . "' 
                           WHERE id = " . $row['id'];
                mysqli_query($conn, $update);
            }

            if ($today > $eta2) {
                // Overdue again: add another 15 days = eta_3
                $eta3 = (clone $eta2)->modify('+15 days');
                $finalEta = $eta3;

                if (empty($row['eta_3'])) {
                    $update = "UPDATE backorders_tbl 
                               SET eta_3 = '" . $eta3->format('Y-m-d') . "' 
                               WHERE id = " . $row['id'];
                    mysqli_query($conn, $update);
                }
            }
        }

        // ✅ Human-readable aging
        $interval = $orderDate->diff($finalEta);

        $parts = [];
        if ($interval->y > 0) {
            $parts[] = $interval->y . " year" . ($interval->y > 1 ? "s" : "");
        }
        if ($interval->m > 0) {
            $parts[] = $interval->m . " month" . ($interval->m > 1 ? "s" : "");
        }
        if ($interval->d > 0 || empty($parts)) {
            // Always show days if no months/years
            $parts[] = $interval->d . " day" . ($interval->d > 1 ? "s" : "");
        }

        $aging = implode(", ", $parts);

        // Determine row class
        if ($today > $finalEta) {
            $rowClass = "table-danger"; // overdue
        } else {
            $daysRemaining = $today->diff($finalEta)->days;
            if ($daysRemaining <= 3) {
                $rowClass = "table-warning"; // due soon
            }
        }
    }

    $row['aging']    = $aging;
    $row['order_date'] = $orderDate->format('m/d/Y');
    $row['eta_1']    = $eta1 ? $eta1->format('m/d/Y') : null;
    $row['eta_2']    = $eta2 ? $eta2->format('m/d/Y') : ($row['eta_2'] ? (new DateTime($row['eta_2']))->format('m/d/Y') : null);
    $row['eta_3']    = $eta3 ? $eta3->format('m/d/Y') : ($row['eta_3'] ? (new DateTime($row['eta_3']))->format('m/d/Y') : null);
    $row['rowClass'] = $rowClass;
    $row['action'] = '
    <div class="btn-group" role="group">
        <button class="btn btn-sm btn-primary updateEtaBtn" data-id="' . $row['id'] . '">
            <i class="fa fa-calendar fa-sm"></i>
        </button>
        <button type="button" class="btn btn-sm btn-info viewBtn" data-id="' . $row['id'] . '">
            <i class="fa fa-eye fa-sm"></i>
        </button>
        <button type="button" class="btn btn-sm btn-warning editBtn" data-id="' . $row['id'] . '">
            <i class="fa fa-pencil  fa-sm"></i>
        </button>
        <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="' . $row['id'] . '">
            <i class="fa fa-trash fa-sm"></i>
        </button>
    </div>';


    $data[] = $row;
}

echo json_encode([
    "data" => $data
]);
