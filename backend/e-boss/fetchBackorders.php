<?php
require('../dbconn.php');
session_start();
header('Content-Type: application/json');

// Fetch all orders first
$query = "SELECT *, (qty * bo_price) AS total 
          FROM backorders_tbl WHERE order_status != 'Cancelled' AND order_status != 'Delivered' AND is_deleted = 0 ORDER BY order_date DESC";

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
        $finalEta = $eta1; // Always use ETA_1 as the final ETA

        // Check if we have ETA_2 or ETA_3 from previous manual updates
        if (!empty($row['eta_2'])) {
            $eta2 = new DateTime($row['eta_2']);
            $finalEta = $eta2;
        }
        if (!empty($row['eta_3'])) {
            $eta3 = new DateTime($row['eta_3']);
            $finalEta = $eta3;
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

        // Determine row class - simple overdue logic
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
    // Determine ETA button data attributes and color based on confirmation status
    $etaButtonClass = "btn-primary"; // Default blue
    $etaButtonData = 'data-id="' . $row['id'] . '"';
    $currentEtaDate = $finalEta ? $finalEta->format('Y-m-d') : "";
    $needsConfirmation = false;

    // Check if ETA is overdue and needs confirmation
    if ($today > $finalEta) {
        // Check if we're using ETA_2 and it's not confirmed
        if (!empty($row['eta_2']) && !$row['eta_2_confirmed']) {
            $needsConfirmation = true;
            $etaButtonData .= ' data-eta-type="eta_2"';
        }
        // Check if we're using ETA_3 and it's not confirmed
        elseif (!empty($row['eta_3']) && !$row['eta_3_confirmed']) {
            $needsConfirmation = true;
            $etaButtonData .= ' data-eta-type="eta_3"';
        }
        // If ETA_1 is overdue and no ETA_2 exists yet
        elseif (empty($row['eta_2'])) {
            $needsConfirmation = true;
            $etaButtonData .= ' data-eta-type="eta_2"';
        }
        // If ETA_2 exists but no ETA_3 yet
        elseif (!empty($row['eta_2']) && empty($row['eta_3'])) {
            $needsConfirmation = true;
            $etaButtonData .= ' data-eta-type="eta_3"';
        }
        // All ETAs exist, update ETA_3
        else {
            $etaButtonData .= ' data-eta-type="eta_3"';
        }
    } else {
        // Not overdue, determine which ETA field to update next
        if (empty($row['eta_2'])) {
            $etaButtonData .= ' data-eta-type="eta_2"';
        } elseif (empty($row['eta_3'])) {
            $etaButtonData .= ' data-eta-type="eta_3"';
        } else {
            $etaButtonData .= ' data-eta-type="eta_3"';
        }
    }

    // Set button color based on confirmation status
    if ($needsConfirmation) {
        $etaButtonClass = "btn-warning"; // Yellow when needs confirmation
    }

    // Add current ETA date to button data
    if ($currentEtaDate) {
        $etaButtonData .= ' data-current-eta="' . $currentEtaDate . '"';
    }

    $row['action'] = '
    <div class="btn-group" role="group">
        <button class="btn btn-sm ' . $etaButtonClass . ' updateEtaBtn" ' . $etaButtonData . ' title="Update ETA">
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
