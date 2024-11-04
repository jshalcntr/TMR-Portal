<?php

require('../../dbconn.php');
require('../../../vendor/autoload.php');
include('../../middleware/pipes.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "SELECT * FROM inventory_records_tbl WHERE 1=1";

    if (!empty($_POST['assetType_export'])) {
        if ($_POST['assetType_export'] == "fa") {
            $sql .= " AND fa_number IS NOT NULL";
        } elseif ($_POST['assetType_export'] == "nonFa") {
            $sql .= " AND fa_number IS NULL";
        }
    }

    if (!empty($_POST['itemType_export']) && $_POST['itemType_export'] !== "all") {
        $itemType = $conn->real_escape_string($_POST['itemType_export']);
        $sql .= " AND item_type = '$itemType'";
    }

    if (empty($_POST['exportAllDate'])) {
        if (!empty($_POST['dateFrom'])) {
            $dateFrom = $_POST['dateFrom'];
            $sql .= " AND date_acquired >= '$dateFrom'";
        }
        if (!empty($_POST['dateTo'])) {
            $dateTo = $_POST['dateTo'];
            $sql .= " AND date_acquired <= '$dateTo'";
        }
    }

    $sql .= " ORDER BY date_acquired DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // header('Content-Type: application/json');
    // echo json_encode($data);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->mergeCells('A1:N1');
    $sheet->setCellValue('A1', 'INVENTORY RECORDS');
    $sheet->mergeCells('A2:A3');
    $sheet->setCellValue('A2', 'ID');
    $sheet->mergeCells('B2:B3');
    $sheet->setCellValue('B2', 'FA Number');
    $sheet->mergeCells('C2:C3');
    $sheet->setCellValue('C2', 'Item Type');
    $sheet->mergeCells('D2:D3');
    $sheet->setCellValue('D2', 'Item Name');
    $sheet->mergeCells('E2:E3');
    $sheet->setCellValue('E2', 'Brand');
    $sheet->mergeCells('F2:F3');
    $sheet->setCellValue('F2', 'Model');
    $sheet->mergeCells('G2:G3');
    $sheet->setCellValue('G2', 'Date Acquired');
    $sheet->mergeCells('H2:H3');
    $sheet->setCellValue('H2', 'Supplier');
    $sheet->mergeCells('I2:I3');
    $sheet->setCellValue('I2', 'Serial Number');
    $sheet->mergeCells('J2:J3');
    $sheet->setCellValue('J2', 'Remarks');
    $sheet->mergeCells('K2:K3');
    $sheet->setCellValue('K2', 'User');
    $sheet->mergeCells('L2:L3');
    $sheet->setCellValue('L2', 'Department');
    $sheet->mergeCells('M2:M3');
    $sheet->setCellValue('M2', 'Status');
    $sheet->mergeCells('N2:N3');
    $sheet->setCellValue('N2', 'Price');

    $rowIndex = 4;

    foreach ($data as $row) {
        $sheet->setCellValue('A' . $rowIndex, $row['id']);
        $sheet->setCellValue('B' . $rowIndex, $row['fa_number']);
        $sheet->setCellValue('C' . $rowIndex, $row['item_type']);
        $sheet->setCellValue('D' . $rowIndex, $row['item_name']);
        $sheet->setCellValue('E' . $rowIndex, $row['brand']);
        $sheet->setCellValue('F' . $rowIndex, $row['model']);
        $sheet->setCellValue('G' . $rowIndex, convertToReadableDate($row['date_acquired']));
        $sheet->setCellValue('H' . $rowIndex, $row['supplier']);
        $sheet->setCellValue('I' . $rowIndex, $row['serial_number']);
        $sheet->setCellValue('J' . $rowIndex, $row['remarks']);
        $sheet->setCellValue('K' . $rowIndex, $row['user']);
        $sheet->setCellValue('L' . $rowIndex, $row['department']);
        $sheet->setCellValue('M' . $rowIndex, $row['status']);
        $sheet->setCellValue('N' . $rowIndex, convertToPhp($row['price']));
        $rowIndex++;
    }

    foreach (range('A', 'N') as $columnId) {
        $sheet->getColumnDimension($columnId)->setAutoSize(true);
    }
    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal('center')->setVertical('center');
    $sheet->getStyle('A1')->getFont()->setName('ToyotaType')->setSize(19);
    $sheet->getStyle('A2:N2')->getFont()->setBold(true);
    $sheet->setAutoFilter('A2:N2');

    $highestRow = $sheet->getHighestRow();

    $sheet->getStyle('A2:M' . $highestRow)->getAlignment()->setHorizontal('center')->setVertical('center');
    $sheet->getStyle('N2')->getAlignment()->setHorizontal('center')->setVertical('center');
    $sheet->getStyle('A2:N' . $highestRow)->getFont()->setName('ToyotaType')->setSize(11);
    $sheet->getStyle('N3:N' . $highestRow)->getAlignment()->setHorizontal('left')->setVertical('center');




    $dateTimeNow = new DateTime();
    $dateTimeNow->setTimezone(new DateTimeZone('Asia/Manila'));
    $dateTimeNow = $dateTimeNow->format('YmdHis');
    $fileName = "inventory$dateTimeNow.xlsx";
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}
