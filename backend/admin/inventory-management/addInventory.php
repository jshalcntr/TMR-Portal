<?php
include('../../dbconn.php');

$itemType = $_POST['itemType'];
$itemCategory = $_POST['itemCategory'];
$itemSpecification = $_POST['itemSpecification'];
$itemBrand = $_POST['itemBrand'];
$itemModel = $_POST['itemModel'];
$user = $_POST['user'];
$computerName = $_POST['computerName'];
$separtment = $_POST['department'];
$dateAcquired = $_POST['dateAcquired'];
$supplier = $_POST['supplierName'];
$serialNumber = $_POST['serialNumber'];
$itemPrice = $_POST['price'];
$status = "Active";
$remarks = $_POST['remarks'];
$newFaNumber = "";

if ($itemPrice > 9999.4) {
    $currentYear = date('y', strtotime($dateAcquired));
    $latestFaNumberSql = "SELECT fa_number FROM inventory_records_tbl
                            WHERE fa_number IS NOT NULL AND fa_number <> ''
                            ORDER BY id DESC LIMIT 1";
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

    $newFaNumber = sprintf("TMRMIS%s-%04d", $currentYear, $newNumber);

    $addItemSql = "INSERT INTO inventory_records_tbl(item_type, item_category, item_specification, brand, model, date_acquired, supplier, serial_number, remarks,user, computer_name, department, status, price, fa_number)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($addItemSql);

    if (!$stmt) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Internal Error. Please Contact the Programmer",
            "data" => $conn->error
        ]);
    } else {
        $stmt->bind_param("sssssssssssssds", $itemType, $itemCategory, $itemSpecification, $itemBrand, $itemModel, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $computerName, $separtment, $status, $itemPrice, $newFaNumber);
        if (!$stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Internal Error. Please Contact the Programmer",
                "data" => $stmt->error
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "Fixed Asset $newFaNumber Added Successfully!",
            ]);
        }
    }
} else {
    $addItemSql = "INSERT INTO inventory_records_tbl(item_type, item_category, item_specification, brand, model, date_acquired, supplier, serial_number, remarks, user, computer_name, department, status, price)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($addItemSql);
    if (!$stmt) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Internal Error. Please Contact the Programmer",
            "data" => $conn->error
        ]);
    } else {
        $stmt->bind_param("sssssssssssssd", $itemType, $itemCategory, $itemSpecification,  $itemBrand, $itemModel, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $computerName, $separtment, $status, $itemPrice);
        if (!$stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Internal Error. Please Contact the Programmer",
                "data" => $stmt->error
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "New $itemType Added Successfully!"
            ]);
        }
    }
}
