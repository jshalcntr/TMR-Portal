<?php

require('../../dbconn.php');
require('../../../vendor/autoload.php');
include('../../middleware/pipes.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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

    if (isset($_POST['itemType_export']) && count($_POST['itemType_export']) > 0) {
        $selectedItemTypes = $_POST['itemType_export'];
        $escapedItemTypes = array_map(function ($itemType) use ($conn) {
            return "'" . $conn->real_escape_string(strtolower($itemType)) . "'";
        }, $selectedItemTypes);

        $sql .= " AND LOWER(item_type) IN (" . implode(',', $escapedItemTypes) . ")";
    }

    if (isset($_POST['status_export']) && count($_POST['status_export']) > 0) {
        $selectedStatus = $_POST['status_export'];
        $escapedStatus = array_map(function ($status) use ($conn) {
            return "'" . $conn->real_escape_string(strtolower($status)) . "'";
        }, $selectedStatus);

        $sql .= " AND LOWER(status) IN (" . implode(',', $escapedStatus) . ")";
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

    $sheet->mergeCells('A1:O1');
    $sheet->setCellValue('A1', 'INVENTORY RECORDS');
    $sheet->mergeCells('A2:A3');
    $sheet->setCellValue('A2', 'ID');
    $sheet->mergeCells('B2:B3');
    $sheet->setCellValue('B2', 'FA Number');
    $sheet->mergeCells('C2:C3');
    $sheet->setCellValue('C2', 'Item Type');
    $sheet->mergeCells('D2:D3');
    $sheet->setCellValue('D2', 'Item Category');
    $sheet->mergeCells('E2:E3');
    $sheet->setCellValue('E2', 'Brand');
    $sheet->mergeCells('F2:F3');
    $sheet->setCellValue('F2', 'Model');
    $sheet->mergeCells('G2:G3');
    $sheet->setCellValue('G2', 'Specification');
    $sheet->mergeCells('H2:H3');
    $sheet->setCellValue('H2', 'Date Acquired');
    $sheet->mergeCells('I2:I3');
    $sheet->setCellValue('I2', 'Supplier');
    $sheet->mergeCells('J2:J3');
    $sheet->setCellValue('J2', 'Serial Number');
    $sheet->mergeCells('K2:K3');
    $sheet->setCellValue('K2', 'Remarks');
    $sheet->mergeCells('L2:L3');
    $sheet->setCellValue('L2', 'User');
    $sheet->mergeCells('M2:M3');
    $sheet->setCellValue('M2', 'Computer Name');
    $sheet->mergeCells('N2:N3');
    $sheet->setCellValue('N2', 'Department');
    $sheet->mergeCells('O2:O3');
    $sheet->setCellValue('O2', 'Status');
    $sheet->mergeCells('P2:P3');
    $sheet->setCellValue('P2', 'Price');

    $rowIndex = 4;

    foreach ($data as $row) {
        $sheet->setCellValue('A' . $rowIndex, $row['id']);
        $sheet->setCellValue('B' . $rowIndex, $row['fa_number']);
        $sheet->setCellValue('C' . $rowIndex, $row['item_type']);
        $sheet->setCellValue('D' . $rowIndex, $row['item_category']);
        $sheet->setCellValue('E' . $rowIndex, $row['brand']);
        $sheet->setCellValue('F' . $rowIndex, $row['model']);
        $sheet->setCellValue('G' . $rowIndex, $row['item_specification']);
        $sheet->setCellValue('H' . $rowIndex, Date::PHPToExcel(new DateTime($row['date_acquired'])));
        $sheet->getStyle('H' . $rowIndex)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);
        $sheet->setCellValue('I' . $rowIndex, $row['supplier']);
        $sheet->setCellValue('J' . $rowIndex, $row['serial_number']);
        $sheet->setCellValue('K' . $rowIndex, $row['remarks']);
        $sheet->setCellValue('L' . $rowIndex, $row['user']);
        $sheet->setCellValue('M' . $rowIndex, $row['computer_name']);
        $sheet->setCellValue('N' . $rowIndex, $row['department']);
        $sheet->setCellValue('O' . $rowIndex, $row['status']);
        $sheet->setCellValue('P' . $rowIndex, convertToPhp($row['price']));
        $rowIndex++;
    }

    foreach (range('A', 'P') as $columnId) {
        $sheet->getColumnDimension($columnId)->setAutoSize(true);
    }
    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal('center')->setVertical('center');
    $sheet->getStyle('A1')->getFont()->setName('ToyotaType')->setSize(19);
    $sheet->getStyle('A2:P2')->getFont()->setBold(true);
    $sheet->setAutoFilter('A2:P2');

    $highestRow = $sheet->getHighestRow();

    $sheet->getStyle('A2:P' . $highestRow)->getAlignment()->setHorizontal('center')->setVertical('center');
    $sheet->getStyle('N2')->getAlignment()->setHorizontal('center')->setVertical('center');
    $sheet->getStyle('A2:P' . $highestRow)->getFont()->setName('ToyotaType')->setSize(11);
    $sheet->getStyle('P4:P' . $highestRow)->getAlignment()->setHorizontal('left')->setVertical('center');
    $sheet->getStyle('H4:H' . $highestRow)->getNumberFormat()->setFormatCode('MMM DD, YYYY');

    $dateTimeNow = new DateTime();
    $dateTimeNow->setTimezone(new DateTimeZone('Asia/Manila'));
    $dateTimeNow = $dateTimeNow->format('YmdHis');
    $fileName = "inventory-$dateTimeNow.xlsx";
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}
