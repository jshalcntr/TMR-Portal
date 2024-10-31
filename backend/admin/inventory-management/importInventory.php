<?php

require('../../dbconn.php');
require('../../../vendor/autoload.php');
require('../../middleware/pipes.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['importFile']) && $_FILES['importFile']['error'] == 0) {
    $file = $_FILES['importFile']['tmp_name'];


    try {
        $spreadSheet = IOFactory::load($file);
        $sheet = $spreadSheet->getActiveSheet();
        $data = [];
        foreach ($sheet->getRowIterator(4) as $row) {
            $id = $sheet->getCell('A' . $row->getRowIndex())->getValue();
            $faNumber = $sheet->getCell('B' . $row->getRowIndex())->getValue();
            $itemType = $sheet->getCell('C' . $row->getRowIndex())->getValue();
            $itemName = $sheet->getCell('D' . $row->getRowIndex())->getValue();
            $brand = $sheet->getCell('E' . $row->getRowIndex())->getValue();
            $model = $sheet->getCell('F' . $row->getRowIndex())->getValue();
            $dateAcquired = convertFromReadableDate($sheet->getCell('G' . $row->getRowIndex())->getValue());
            $supplier = $sheet->getCell('H' . $row->getRowIndex())->getValue();
            $serialNumber = $sheet->getCell('I' . $row->getRowIndex())->getValue();
            $remarks = $sheet->getCell('J' . $row->getRowIndex())->getValue();
            $user = $sheet->getCell('K' . $row->getRowIndex())->getValue();
            $department = $sheet->getCell('L' . $row->getRowIndex())->getValue();
            $status = $sheet->getCell('M' . $row->getRowIndex())->getValue();
            $price = convertFromPhp($sheet->getCell('N' . $row->getRowIndex())->getValue());



            // $rowData = [
            //     'id' => $sheet->getCell('A' . $row->getRowIndex())->getValue(),
            //     'faNumber' => $sheet->getCell('B' . $row->getRowIndex())->getValue(),
            //     'itemType' => $sheet->getCell('C' . $row->getRowIndex())->getValue(),
            //     'itemName' => $sheet->getCell('D' . $row->getRowIndex())->getValue(),
            //     'brand' => $sheet->getCell('E' . $row->getRowIndex())->getValue(),
            //     'model' => $sheet->getCell('F' . $row->getRowIndex())->getValue(),
            //     'dateAcquired' => convertFromReadableDate($sheet->getCell('G' . $row->getRowIndex())->getValue()),
            //     'supplier' => $sheet->getCell('H' . $row->getRowIndex())->getValue(),
            //     'serialNumber' => $sheet->getCell('I' . $row->getRowIndex())->getValue(),
            //     'remarks' => $sheet->getCell('J' . $row->getRowIndex())->getValue(),
            //     'user' => $sheet->getCell('K' . $row->getRowIndex())->getValue(),
            //     'department' => $sheet->getCell('L' . $row->getRowIndex())->getValue(),
            //     'status' => $sheet->getCell('M' . $row->getRowIndex())->getValue(),
            //     'price' => convertFromPhp($sheet->getCell('N' . $row->getRowIndex())->getValue()),
            // ];
            // $data[] = $rowData;
            if (!$id) {
                if (!$faNumber) {
                    if ($price > 9999.4) {
                        $currentYear = date('y', strtotime($dateAcquired));
                        $latestFaNumberSql = "SELECT fa_number FROM inventory_records_tbl
                            WHERE fa_number LIKE 'TMRMIS$currentYear-%'
                            ORDER BY fa_number DESC LIMIT 1";
                        $stmt = $conn->prepare($latestFaNumberSql);
                        $stmt->execute();
                        $latesFaNumberResult = $stmt->get_result();
                        $stmt->close();

                        if ($latesFaNumberResult->num_rows > 0) {
                            $latestFaNumberRow = $latesFaNumberResult->fetch_assoc();

                            $latesFaNumberRow = $latestFaNumberRow['fa_number'];

                            $parts = explode('-', $latesFaNumberRow);

                            $latestNumber = (int)$parts[1];

                            $newNumber = $latestNumber + 1;
                        } else {
                            $newNumber = 1;
                        }
                        $faNumber = sprintf("TMRMIS%s-%04d", $currentYear, $newNumber);

                        $addItemSql = "INSERT INTO inventory_records_tbl(item_type, item_name, brand, model, date_acquired, supplier, serial_number, remarks, user, department, status, price, fa_number)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($addItemSql);
                        $stmt->bind_param("sssssssssssds", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber);
                    } else {
                        $addItemSql = "INSERT INTO inventory_records_tbl(item_type, item_name, brand, model, date_acquired, supplier, serial_number, remarks, user, department, status, price)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($addItemSql);
                        $stmt->bind_param("sssssssssssd", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price);
                    }
                } else {
                    $faNumberPattern = '/^TMR\d{2}-\d{4}$/';
                    if (preg_match($faNumberPattern, $faNumber)) {
                        $checkFaNumberSql = "SELECT * FROM inventory_records_tbl WHERE fa_number = ?";
                        $stmt = $conn->prepare($checkFaNumberSql);
                        $stmt->bind_param("s", $faNumber);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $updateItemSql = "UPDATE inventory_records_tbl SET item_type = ?, item_name = ?, brand = ?, model = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, department = ?, status = ?, price = ? WHERE fa_number = ?";
                            $stmt = $conn->prepare($updateItemSql);
                            $stmt->bind_param("sssssssssssds", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber);
                        } else {
                            $addItemSql = "INSERT INTO inventory_records_tbl(item_type, item_name, brand, model, date_acquired, supplier, serial_number, remarks, user, department, status, price, fa_number)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($addItemSql);
                            $stmt->bind_param("sssssssssssds", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber);
                        }
                    } else {
                        $currentYear = date('y', strtotime($dateAcquired));
                        $latestFaNumberSql = "SELECT fa_number FROM inventory_records_tbl
                                                WHERE fa_number LIKE 'TMRMIS$currentYear-%'
                                                ORDER BY fa_number DESC LIMIT 1";
                        $stmt = $conn->prepare($latestFaNumberSql);
                        $stmt->execute();
                        $latesFaNumberResult = $stmt->get_result();
                        $stmt->close();

                        if ($latesFaNumberResult->num_rows > 0) {
                            $latestFaNumberRow = $latesFaNumberResult->fetch_assoc();

                            $latesFaNumberRow = $latestFaNumberRow['fa_number'];

                            $parts = explode('-', $latesFaNumberRow);

                            $latestNumber = (int)$parts[1];

                            $newNumber = $latestNumber + 1;
                        } else {
                            $newNumber = 1;
                        }
                        $faNumber = sprintf("TMRMIS%s-%04d", $currentYear, $newNumber);

                        $addItemSql = "INSERT INTO inventory_records_tbl(item_type, item_name, brand, model, date_acquired, supplier, serial_number, remarks, user, department, status, price, fa_number)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($addItemSql);
                        $stmt->bind_param("sssssssssssds", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber);
                    }
                }
            } else {
                $checkIdSql = "SELECT * FROM inventory_records_tbl WHERE id = ?";
                $stmt = $conn->prepare($checkIdSql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();


                if ($result->num_rows > 0) {
                    if (!$faNumber) {
                        if ($price > 9999.4) {
                            $currentYear = date('y', strtotime($dateAcquired));
                            $latestFaNumberSql = "SELECT fa_number FROM inventory_records_tbl
                                                    WHERE fa_number LIKE 'TMRMIS$currentYear-%'
                                                    ORDER BY fa_number DESC LIMIT 1";
                            $stmt = $conn->prepare($latestFaNumberSql);
                            $stmt->execute();
                            $latesFaNumberResult = $stmt->get_result();
                            $stmt->close();

                            if ($latesFaNumberResult->num_rows > 0) {
                                $latestFaNumberRow = $latesFaNumberResult->fetch_assoc();

                                $latesFaNumberRow = $latestFaNumberRow['fa_number'];

                                $parts = explode('-', $latesFaNumberRow);

                                $latestNumber = (int)$parts[1];

                                $newNumber = $latestNumber + 1;
                            } else {
                                $newNumber = 1;
                            }
                            $faNumber = sprintf("TMRMIS%s-%04d", $currentYear, $newNumber);
                            $updateItemSql = "UPDATE inventory_records_tbl SET item_type = ?, item_name = ?, brand = ?, model = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, department = ?, status = ?, price = ?, fa_number = ? WHERE id = ?";
                            $stmt = $conn->prepare($updateItemSql);
                            $stmt->bind_param("sssssssssssdsi", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber, $id);
                        }
                    } else {
                        $faNumberPattern = '/^TMRMIS\d{2}-\d{4}$/';

                        if (preg_match($faNumberPattern, $faNumber)) {
                            $updateItemSql = "UPDATE inventory_records_tbl SET item_type = ?, item_name = ?, brand = ?, model = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, department = ?, status = ?, price = ?, fa_number = ? WHERE id = ?";
                            $stmt = $conn->prepare($updateItemSql);
                            $stmt->bind_param("sssssssssssdsi", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber, $id);
                        } else {
                            $updateItemSql = "UPDATE inventory_records_tbl SET item_type = ?, item_name = ?, brand = ?, model = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, department = ?, status = ?, price = ? WHERE id = ?";
                            $stmt = $conn->prepare($updateItemSql);
                            $stmt->bind_param("sssssssssssdi", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $id);
                        }
                    }
                } else {
                    if (!$faNumber) {
                        if ($price > 9999.4) {
                            $currentYear = date('y', strtotime($dateAcquired));
                            $latestFaNumberSql = "SELECT fa_number FROM inventory_records_tbl
                                                    WHERE fa_number LIKE 'TMRMIS$currentYear-%'
                                                    ORDER BY fa_number DESC LIMIT 1";
                            $stmt = $conn->prepare($latestFaNumberSql);
                            $stmt->execute();
                            $latesFaNumberResult = $stmt->get_result();
                            $stmt->close();

                            if ($latesFaNumberResult->num_rows > 0) {
                                $latestFaNumberRow = $latesFaNumberResult->fetch_assoc();

                                $latesFaNumberRow = $latestFaNumberRow['fa_number'];

                                $parts = explode('-', $latesFaNumberRow);

                                $latestNumber = (int)$parts[1];

                                $newNumber = $latestNumber + 1;
                            } else {
                                $newNumber = 1;
                            }
                            $faNumber = sprintf("TMRMIS%s-%04d", $currentYear, $newNumber);
                            $updateItemSql = "UPDATE inventory_records_tbl SET item_type = ?, item_name = ?, brand = ?, model = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, department = ?, status = ?, price = ?, fa_number = ? WHERE id = ?";
                            $stmt = $conn->prepare($updateItemSql);
                            $stmt->bind_param("sssssssssssdsi", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber, $id);
                        }
                        $addItemSql = "INSERT INTO inventory_records_tbl(item_type, item_name, brand, model, date_acquired, supplier, serial_number, remarks, user, department, status, price, fa_number)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($addItemSql);
                        $stmt->bind_param("sssssssssssds", $itemType, $itemName, $brand, $model, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $department, $status, $price, $faNumber);
                    }
                }
            }
            if ($stmt == false) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Internal Error. Please Contact MIS",
                    "data" => $conn->error
                ]);
                break;
                exit;
            } else {
                if (!$stmt->execute()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "status" => "internal-error",
                        "message" => "Internal Error. Please Contact MIS",
                        "data" => $stmt->error
                    ]);
                    break;
                    exit;
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Import Successful",
        ]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => "No File Selected"
    ]);
}
