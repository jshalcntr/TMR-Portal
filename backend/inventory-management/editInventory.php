<?php
include('../dbconn.php');

$id = $_POST['id'];
$itemType = $_POST['itemType'];
$itemCategory = $_POST['itemCategory'];
$itemBrand = $_POST['itemBrand'];
$itemModel = $_POST['itemModel'];
$itemSpecification = $_POST['itemSpecification'];
$user = $_POST['user'];
$computerName = $_POST['computerName'];
$separtment = $_POST['department'];
$dateAcquired = $_POST['dateAcquired'];
$supplier = $_POST['supplierName'];
$serialNumber = $_POST['serialNumber'];
$itemPrice = $_POST['price'];
$remarks = $_POST['remarks'];

$sql = "UPDATE inventory_records_tbl SET item_type = ?, item_category = ?, brand = ?, model = ?, item_specification = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, computer_name = ?, department = ?, price = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Update Inventory. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("ssssssssssssdi", $itemType, $itemCategory, $itemBrand, $itemModel, $itemSpecification, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $computerName, $separtment, $itemPrice, $id);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Update Inventory. Please Contact the Programmer",
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
