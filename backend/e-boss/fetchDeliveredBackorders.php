<?php
require('../dbconn.php');
require('../middleware/pipes.php');
session_start();
header('Content-Type: application/json');

// Fetch delivered orders with appointment information
$query = "SELECT b.*, 
            (b.qty * b.bo_price) AS total,
            a.appointment_date,
            a.appointment_time,
            a.notes AS appointment_remarks,
            u.full_name AS scheduled_by
          FROM backorders_tbl b
          LEFT JOIN backorders_appointment_tbl a ON b.id = a.backorder_id
          LEFT JOIN accounts_tbl u ON a.created_by = u.id
          WHERE b.order_status = 'Delivered' 
          AND b.is_deleted = 0 
          ORDER BY b.order_date DESC";

$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Calculate aging for delivered items (static calculation)
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
    $row['order_date'] = convertToReadableDate($row['order_date']);
    $row['eta_1'] = $eta1 ? convertToReadableDate($row['eta_1']) : '';
    $row['eta_2'] = !empty($row['eta_2']) ? convertToReadableDate($row['eta_2']) : '';
    $row['eta_3'] = !empty($row['eta_3']) ? convertToReadableDate($row['eta_3']) : '';
    $row['aging'] = $aging;

    // Format appointment information
    $row['appointment_date'] = !empty($row['appointment_date']) ? convertToReadableDate($row['appointment_date']) : '';
    $row['appointment_time'] = !empty($row['appointment_time']) ? date('h:i A', strtotime($row['appointment_time'])) : '';
    $row['appointment_remarks'] = $row['appointment_remarks'] ?? '';
    $row['scheduled_by'] = $row['scheduled_by'] ?? '';

    // Delivered orders = static row style
    $row['rowClass'] = "table-success";

    // Add action buttons
    $row['action'] = '
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-sm btn-info viewBtn" 
                data-id="' . $row['id'] . '" title="View Details">
                <i class="fa fa-eye fa-sm"></i>
            </button>
            <button type="button" class="btn btn-sm btn-warning restoreBtn" 
                data-id="' . $row['id'] . '" title="Restore to Pending">
                <i class="fa fa-undo fa-sm"></i>
            </button>
            <button type="button" class="btn btn-sm btn-danger deleteBtn" 
                data-id="' . $row['id'] . '" title="Delete Backorder">
                <i class="fa fa-trash fa-sm"></i>
            </button>
        </div>';

    // Add delivery date if available (assuming there's a delivery_date field)
    $row['delivery_date'] = !empty($row['delivery_date']) ? (new DateTime($row['delivery_date']))->format('m/d/Y') : "—";
    $row['remarks'] = !empty($row['remarks']) ? $row['remarks'] : "—";

    $data[] = $row;
}

echo json_encode([
    "data" => $data
]);
