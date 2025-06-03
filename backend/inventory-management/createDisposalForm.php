<?php
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}
require('../dbconn.php');
require('../../vendor/autoload.php');
include('../middleware/pipes.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;

$forDisposalSql = "SELECT inventory_records_tbl.fa_number, inventory_records_tbl.item_type, inventory_records_tbl.item_category, inventory_records_tbl.user, inventory_records_tbl.department, inventory_records_tbl.date_acquired, inventory_disposal_tbl.date_added, inventory_disposal_tbl.remarks FROM inventory_records_tbl JOIN inventory_disposal_tbl ON inventory_records_tbl.id = inventory_disposal_tbl.inventory_id WHERE inventory_disposal_tbl.isDisposed = 0 ORDER BY `inventory_records_tbl`.`item_category` ASC";
$stmt = $conn->prepare($forDisposalSql);
$data = [];
if ($stmt == false) {
    echo $conn->error;
} else {
    if (!$stmt->execute()) {
        echo $stmt->error;
    } else {
        $forDisposalResult = $stmt->get_result();
        while ($row = $forDisposalResult->fetch_assoc()) {
            $data[] = $row;
        }
    }
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->mergeCells('A1:E3');
$logo1 = new Drawing();
$logo1->setName('TMR Logo');
$logo1->setDescription('TMR Logo');
$logo1->setPath('../../assets/img/tmr-logo-2.png');
$logo1->setHeight(50);
$logo1->setCoordinates('A1');
$logo1->setOffsetX(5);
$logo1->setOffsetY(5);
$logo1->setWorksheet($sheet);
$logo2 = new Drawing();
$logo2->setName('OG Logo');
$logo2->setDescription('OG Logo');
$logo2->setPath('../../assets/img/og-logo.png');
$logo2->setHeight(60);
$logo2->setCoordinates('E1');
$logo2->setOffsetX(70);
$logo2->setOffsetY(0);
$logo2->setWorksheet($sheet);

$sheet->mergeCells('A5:E5');
$sheet->getStyle('A5:E5')->getFont()->setBold(true)->setName('Toyota Type')->setSize(14);
$sheet->getStyle('A5')->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->setCellValue('A5', 'DISPOSAL FORM');
$sheet->setCellValue('A6', 'ITEM');
$sheet->setCellValue('B6', 'ITEM USER');
$sheet->setCellValue('C6', 'DEPARTMENT');
$sheet->setCellValue('D6', 'ITEM CATEGORY');
$sheet->setCellValue('E6', 'DATE ACQUIRED');
$sheet->getStyle('A6:E6')->getFont()->setBold(true)->setName('Toyota Type')->setSize(10);
$sheet->getStyle('A6:E6')->getAlignment()->setHorizontal('center')->setVertical('center');
$rowIndex = 7;
$itemNumber = 1;

foreach ($data as $row) {
    $sheet->setCellValue('A' . $rowIndex, $itemNumber);
    $sheet->setCellValue('B' . $rowIndex, $row['user']);
    $sheet->setCellValue('C' . $rowIndex, $row['department']);
    $sheet->setCellValue('D' . $rowIndex, $row['item_category']);
    $sheet->setCellValue('E' . $rowIndex, convertToReadableDate($row['date_acquired']));
    $rowIndex++;
    $itemNumber++;
}
$highestRow = $sheet->getHighestRow();
$sheet->getStyle('A7:E' . $highestRow)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->getStyle('A7:E' . $highestRow)->getFont()->setName('Toyota Type')->setSize(10);

$sheet->getStyle('A5:E' . $highestRow)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);

$itemNameSql = "SELECT item_type, item_category, COUNT(item_category) AS quantity
                FROM inventory_records_tbl
                JOIN inventory_disposal_tbl ON inventory_records_tbl.id = inventory_disposal_tbl.inventory_id
                WHERE inventory_disposal_tbl.isDisposed = 0
                GROUP BY item_category";
$stmt2 = $conn->prepare($itemNameSql);
$itemNames = [];

if ($stmt2 == false) {
    echo $conn->error;
} else {
    if (!$stmt2->execute()) {
        echo $stmt2->error;
    } else {
        $itemNameResult = $stmt2->get_result();
        while ($row = $itemNameResult->fetch_assoc()) {
            $itemNames[] = $row;
        }
    }
}

$sheet->mergeCells('H5:J5');
$sheet->getStyle('H5:J5')->getFont()->setBold(true)->setName('Toyota Type')->setSize(14);
$sheet->getStyle('H5')->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->setCellValue('H5', 'ITEM QUANTITY');

$sheet->getStyle('H6:J6')->getFont()->setBold(true)->setName('Toyota Type')->setSize(10);
$sheet->getStyle('H6:J6')->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->getStyle('H6:J6')->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);
$sheet->setCellValue('H6', 'ITEM NUMBER');
$sheet->setCellValue('I6', 'ITEM CATEGORY');
$sheet->setCellValue('J6', 'QUANTITY');

$rowIndex = 7;
$itemNumber = 1;
$totalQuantity = 0;
foreach ($itemNames as $itemName) {
    $sheet->setCellValue('H' . $rowIndex, $itemNumber);
    $sheet->setCellValue('I' . $rowIndex, $itemName['item_category']);
    $sheet->setCellValue('J' . $rowIndex, $itemName['quantity']);
    $sheet->getStyle('H' . $rowIndex . ':J' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
    $sheet->getStyle('H' . $rowIndex . ':J' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(10);
    $sheet->getStyle('H' . $rowIndex . ':J' . $rowIndex)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => '000000']
            ]
        ]
    ]);
    $rowIndex++;
    $itemNumber++;
    $totalQuantity += $itemName['quantity'];
}

$sheet->getStyle('H' . $rowIndex . ':J' . $rowIndex)->getFont()->setBold(true)->setName('Toyota Type')->setSize(10);
$sheet->getStyle('H' . $rowIndex . ':J' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->setCellValue('I' . $rowIndex, 'TOTAL : ');
$sheet->setCellValue('J' . $rowIndex, $totalQuantity);

$rowIndex += 4;
$preparedBy = "Dave Rama";
$preparedByPosition = "SR. IT Officer";
$counterCheck = "Jaymar Almonte";
$counterCheckPosition = "PURCHASING";
$approvedBy = "Jaymar D. Lustre";
$approvedByPosition = "MIS Assistant Manager";
$notedBy1 = "John Rhey De Guzman";
$notedBy1Position = "PCO";
$notedBy2 = "Arlenton R. Reyes";
$notedBy2Position = "ASSISTANT BUILDING ADMIN MANAGER";
$approvedBy1 = "Maribeth C. Rongcal";
$approvedBy1Position = "FINANCE AND ACCOUNTING MANAGER";
$approvedBy2 = "Nel Diane B. Alfonso";
$approvedBy2Position = "HRAD MANAGER";

$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->mergeCells('H' . $rowIndex . ':I' . ($rowIndex + 1));
$sheet->setCellValue('H' . $rowIndex, 'Prepared By:');
$sheet->mergeCells('K' . $rowIndex . ':L' . ($rowIndex + 1));
$sheet->setCellValue('K' . $rowIndex, 'Counter Check:');
$sheet->mergeCells('N' . $rowIndex . ':O' . ($rowIndex + 1));
$sheet->setCellValue('N' . $rowIndex, 'Approved By:');

$rowIndex += 3;
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->mergeCells('H' . $rowIndex . ':I' . $rowIndex);
$sheet->setCellValue('H' . $rowIndex, $preparedBy);
$sheet->getStyle('H' . $rowIndex . ':I' . $rowIndex)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);
$sheet->mergeCells('K' . $rowIndex . ':L' . $rowIndex);
$sheet->setCellValue('K' . $rowIndex, $counterCheck);
$sheet->getStyle('K' . $rowIndex . ':L' . $rowIndex)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);
$sheet->mergeCells('N' . $rowIndex . ':O' . $rowIndex);
$sheet->setCellValue('N' . $rowIndex, $approvedBy);
$sheet->getStyle('N' . $rowIndex . ':O' . $rowIndex)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);
$rowIndex += 1;

$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->mergeCells('H' . $rowIndex . ':I' . $rowIndex);
$sheet->setCellValue('H' . $rowIndex, $preparedByPosition);
$sheet->mergeCells('K' . $rowIndex . ':L' . $rowIndex);
$sheet->setCellValue('K' . $rowIndex, $counterCheckPosition);
$sheet->mergeCells('N' . $rowIndex . ':O' . $rowIndex);
$sheet->setCellValue('N' . $rowIndex, $approvedByPosition);
$rowIndex += 3;

$sheet->mergeCells('K' . $rowIndex . ':L' . $rowIndex);
$sheet->getStyle('K' . $rowIndex . ':L' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('K' . $rowIndex . ':L' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->setCellValue('K' . $rowIndex, 'NOTED BY:');
$rowIndex += 2;

$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->mergeCells('H' . $rowIndex . ':I' . $rowIndex);
$sheet->setCellValue('H' . $rowIndex, $notedBy1);
$sheet->getStyle('H' . $rowIndex . ':I' . $rowIndex)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);
$sheet->mergeCells('N' . $rowIndex . ':O' . $rowIndex);
$sheet->setCellValue('N' . $rowIndex, $notedBy2);
$sheet->getStyle('N' . $rowIndex . ':O' . $rowIndex)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);
$rowIndex += 1;

$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->mergeCells('H' . $rowIndex . ':I' . $rowIndex);
$sheet->setCellValue('H' . $rowIndex, $notedBy1Position);
$sheet->mergeCells('N' . $rowIndex . ':O' . $rowIndex);
$sheet->setCellValue('N' . $rowIndex, $notedBy2Position);

$rowIndex += 3;

$sheet->mergeCells('K' . $rowIndex . ':L' . $rowIndex);
$sheet->getStyle('K' . $rowIndex . ':L' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('K' . $rowIndex . ':L' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->setCellValue('K' . $rowIndex, 'APPROVED BY:');

$rowIndex += 2;

$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->mergeCells('H' . $rowIndex . ':I' . $rowIndex);
$sheet->setCellValue('H' . $rowIndex, $approvedBy1);
$sheet->getStyle('H' . $rowIndex . ':I' . $rowIndex)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);
$sheet->mergeCells('N' . $rowIndex . ':O' . $rowIndex);
$sheet->setCellValue('N' . $rowIndex, $approvedBy2);
$sheet->getStyle('N' . $rowIndex . ':O' . $rowIndex)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '000000']
        ]
    ]
]);

$rowIndex += 1;

$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getFont()->setName('Toyota Type')->setSize(8);
$sheet->getStyle('H' . $rowIndex . ':O' . $rowIndex)->getAlignment()->setHorizontal('center')->setVertical('center');
$sheet->mergeCells('H' . $rowIndex . ':I' . $rowIndex);
$sheet->setCellValue('H' . $rowIndex, $approvedBy1Position);
$sheet->mergeCells('N' . $rowIndex . ':O' . $rowIndex);
$sheet->setCellValue('N' . $rowIndex, $approvedBy2Position);

foreach (range('A', 'O') as $columnId) {
    $sheet->getColumnDimension($columnId)->setAutoSize(true);
}
// var_dump($itemName);
$dateTimeNow = new DateTime();
$dateTimeNow->setTimezone(new DateTimeZone('Asia/Manila'));
$dateTimeNow = $dateTimeNow->format('Y-m-d');
$fileName = "disposalForm-$dateTimeNow.xlsx";
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
