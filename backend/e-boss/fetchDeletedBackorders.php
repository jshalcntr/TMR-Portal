<?php
require('../dbconn.php');

header('Content-Type: application/json');

// Fetch only Deleted orders
$query = "SELECT *, (qty * bo_price) AS total 
          FROM backorders_tbl 
          WHERE is_deleted = 1 
          ORDER BY order_date DESC";

$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Calculate aging for deleted items (static calculation)
    $orderDate = new DateTime($row['order_date']);
    $eta1 = !empty($row['eta_1']) ? new DateTime($row['eta_1']) : null;

    $aging = '';
    if ($eta1) {
        $today = new DateTime();
        if ($today <= $eta1) {
            $finalEta = $eta1;
        } else {
            $eta2 = (clone $eta1)->modify('+15 days');
            $finalEta = $eta2;
            if ($today > $eta2) {
                $eta3 = (clone $eta2)->modify('+15 days');
                $finalEta = $eta3;
            }
        }

        $interval = $orderDate->diff($finalEta);
        $parts = [];
        if ($interval->y > 0) $parts[] = $interval->y . " year" . ($interval->y > 1 ? "s" : "");
        if ($interval->m > 0) $parts[] = $interval->m . " month" . ($interval->m > 1 ? "s" : "");
        if ($interval->d > 0 || empty($parts)) $parts[] = $interval->d . " day" . ($interval->d > 1 ? "s" : "");
        $aging = implode(", ", $parts);
    }

    // Format dates
    $row['order_date'] = $orderDate->format('m/d/Y');
    $row['eta_1'] = $eta1 ? $eta1->format('m/d/Y') : null;
    $row['eta_2'] = !empty($row['eta_2']) ? (new DateTime($row['eta_2']))->format('m/d/Y') : null;
    $row['eta_3'] = !empty($row['eta_3']) ? (new DateTime($row['eta_3']))->format('m/d/Y') : null;
    $row['aging'] = $aging;

    // Deleted orders = static row style
    $row['rowClass'] = "table-danger";

    // Add action buttons
    $row['action'] = '
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-info viewBtn" 
                data-id="' . $row['id'] . '" title="View Details">
                <i class="fa fa-eye fa-sm"></i>
            </button>
            <button type="button" class="btn btn-sm btn-success restoreBtn" 
                data-id="' . $row['id'] . '" title="Restore Backorder">
                <i class="fa fa-undo fa-sm"></i>
            </button>
            <button type="button" class="btn btn-sm btn-danger permanentDeleteBtn" 
                data-id="' . $row['id'] . '" title="Permanent Delete">
                <i class="fa fa-trash-alt fa-sm"></i>
            </button>
        </div>';

    // Add delete reason if available
    $row['delete_reason'] = !empty($row['delete_reason']) ? $row['delete_reason'] : "—";
    $row['remarks'] = !empty($row['remarks']) ? $row['remarks'] : "—";

    $data[] = $row;
}

echo json_encode([
    "data" => $data
]);
