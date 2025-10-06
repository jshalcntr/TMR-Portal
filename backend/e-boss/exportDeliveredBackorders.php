<?php
require('../dbconn.php');
require_once('../../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Set headers for Excel download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="delivered_backorders_export_' . date('Y-m-d_H-i-s') . '.xlsx"');
header('Cache-Control: max-age=0');

// Fetch only Delivered orders
$query = "SELECT *, (qty * bo_price) AS total 
          FROM backorders_tbl 
          WHERE order_status = 'Delivered' AND is_deleted = 0
          ORDER BY order_date DESC";

$result = mysqli_query($conn, $query);

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set title
$sheet->setTitle('Delivered Backorders Export');

// Define headers
$headers = [
    'A' => 'RO Number',
    'B' => 'Customer Name',
    'C' => 'Order Date',
    'D' => 'Aging',
    'E' => 'Order No',
    'F' => 'Source',
    'G' => 'Part Number',
    'H' => 'Part Name',
    'I' => 'Qty',
    'J' => 'BO Price',
    'K' => 'Total',
    'L' => '1st ETA',
    'M' => '2nd ETA',
    'N' => '3rd ETA',
    'O' => 'Order Type',
    'P' => 'Service Type',
    'Q' => 'Service Estimator',
    'R' => 'Unit Model',
    'S' => 'Plate No',
    'T' => 'Unit Status',
    'U' => 'Remarks',
    'V' => 'Order Status',
    'W' => 'Delivery Date'
];

// Set headers
$row = 1;
foreach ($headers as $col => $header) {
    $sheet->setCellValue($col . $row, $header);
}

// Style headers
$headerRange = 'A1:W1';
$sheet->getStyle($headerRange)->getFont()->setBold(true);
$sheet->getStyle($headerRange)->getFill()
    ->setFillType(Fill::FILL_SOLID)
    ->getStartColor()->setRGB('28A745'); // Green color for delivered items
$sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
$sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Add data rows
$row = 2;
while ($data = mysqli_fetch_assoc($result)) {
    // Calculate aging for delivered items (static calculation)
    $orderDate = new DateTime($data['order_date']);
    $eta1 = !empty($data['eta_1']) ? new DateTime($data['eta_1']) : null;

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

    $sheet->setCellValue('A' . $row, $data['ro_number']);
    $sheet->setCellValue('B' . $row, $data['customer_name']);
    $sheet->setCellValue('C' . $row, $orderDate->format('m/d/Y'));
    $sheet->setCellValue('D' . $row, $aging);
    $sheet->setCellValue('E' . $row, $data['order_no']);
    $sheet->setCellValue('F' . $row, $data['source']);
    $sheet->setCellValue('G' . $row, $data['part_number']);
    $sheet->setCellValue('H' . $row, $data['part_name']);
    $sheet->setCellValue('I' . $row, $data['qty']);
    $sheet->setCellValue('J' . $row, number_format($data['bo_price'], 2));
    $sheet->setCellValue('K' . $row, number_format($data['total'], 2));
    $sheet->setCellValue('L' . $row, $eta1 ? $eta1->format('m/d/Y') : '');
    $sheet->setCellValue('M' . $row, !empty($data['eta_2']) ? (new DateTime($data['eta_2']))->format('m/d/Y') : '');
    $sheet->setCellValue('N' . $row, !empty($data['eta_3']) ? (new DateTime($data['eta_3']))->format('m/d/Y') : '');
    $sheet->setCellValue('O' . $row, $data['order_type']);
    $sheet->setCellValue('P' . $row, $data['service_type']);
    $sheet->setCellValue('Q' . $row, $data['service_estimator']);
    $sheet->setCellValue('R' . $row, $data['unit_model']);
    $sheet->setCellValue('S' . $row, $data['plate_no']);
    $sheet->setCellValue('T' . $row, $data['unit_status']);
    $sheet->setCellValue('U' . $row, $data['remarks']);
    $sheet->setCellValue('V' . $row, $data['order_status']);
    $sheet->setCellValue('W' . $row, !empty($data['delivery_date']) ? (new DateTime($data['delivery_date']))->format('m/d/Y') : '—');

    $row++;
}

// Auto-size columns
foreach (range('A', 'W') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Add borders
$allRange = 'A1:W' . ($row - 1);
$sheet->getStyle($allRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Create writer and save
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

mysqli_close($conn);
