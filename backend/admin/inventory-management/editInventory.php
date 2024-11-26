<?php
include('../../dbconn.php');

$id = $_POST['id'];
$itemType = $_POST['itemType'];
$itemBrand = $_POST['itemBrand'];
$itemModel = $_POST['itemModel'];
$user = $_POST['user'];
$separtment = $_POST['department'];
$dateAcquired = $_POST['dateAcquired'];
$supplier = $_POST['supplierName'];
$serialNumber = $_POST['serialNumber'];
$itemPrice = $_POST['price'];
$remarks = $_POST['remarks'];

$sql = "UPDATE inventory_records_tbl SET item_type = ?, brand = ?, model = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, department = ?, price = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("sssssssssdi", $itemType, $itemBrand, $itemModel, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $separtment, $itemPrice, $id);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Internal Error. Please Contact MIS",
            "data" => $stmt->error
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Inventory Edited Successfully!",
        ]);
    }
}
