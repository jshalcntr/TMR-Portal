<?php
require "../dbconn.php";
require "../middleware/pipes.php";

$sql = "SELECT * FROM inventory_records_tbl WHERE status <> 'Disposed' AND status <> 'Under Disposal'";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Inventory. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inventory. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $inventory = [];
        $inventoryResult = $stmt->get_result();
        while ($inventoryRow = $inventoryResult->fetch_assoc()) {
            $id = $inventoryRow['id'];
            $faNumber = $inventoryRow['fa_number'];
            $itemType = $inventoryRow['item_type'];
            $itemCategory = $inventoryRow['item_category'];
            $user = $inventoryRow['user'];
            $computerName = $inventoryRow['computer_name'];
            $brand = $inventoryRow['brand'];
            $model = $inventoryRow['model'];
            $dateAcquired = $inventoryRow['date_acquired'];
            $dateAcquiredReadable = convertToReadableDate($dateAcquired);
            $supplier = $inventoryRow['supplier'];
            $serialNumber = $inventoryRow['serial_number'];
            $department = $inventoryRow['department'];
            $status = $inventoryRow['status'];
            $price = $inventoryRow['price'];
            $remarks = $inventoryRow['remarks'];

            $inventory[] = [
                "id" => $id,
                "faNumber" => $faNumber == true ? $faNumber : "N/A",
                "itemType" => $itemType,
                "itemCategory" => $itemCategory,
                "user" => $user,
                "computerName" => $computerName,
                "brand" => $brand,
                "model" => $model,
                "dateAcquired" => $dateAcquired,
                "dateAcquiredReadable" => $dateAcquiredReadable,
                "supplier" => $supplier,
                "serialNumber" => $serialNumber,
                "department" => $department,
                "status" => $status,
                "price" => floatval($price),
                "pricePhp" => convertToPhp($price),
                "remarks" => $remarks == true ? $remarks : "No Remarks"
            ];
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $inventory
        ]);
    }
}
