<?php
include('../../dbconn.php');

$id = $_POST['id'];
$itemType = $_POST['itemType'];
$itemName = $_POST['itemName'];
$itemBrand = $_POST['itemBrand'];
$itemModel = $_POST['itemModel'];
$user = $_POST['user'];
$separtment = $_POST['department'];
$dateAcquired = $_POST['dateAcquired'];
$supplier = $_POST['supplierName'];
$serialNumber = $_POST['serialNumber'];
$itemPrice = $_POST['price'];
$status = $_POST['status'];
$remarks = $_POST['remarks'];

$sql = "UPDATE inventory_records_tbl SET item_type = ?, item_name = ?, brand = ?, model = ?, date_acquired = ?, supplier = ?, serial_number = ?, remarks = ?, user = ?, department = ?, status = ?, price = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt == false) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("sssssssssssdi", $itemType, $itemName, $itemBrand, $itemModel, $dateAcquired, $supplier, $serialNumber, $remarks, $user, $separtment, $status, $itemPrice, $id);
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
