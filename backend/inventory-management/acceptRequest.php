<?php
include('../dbconn.php');

$requestId = $_POST['requestId'];
$isEdited = false;
// ? Fetch Request Data from Database
$sql = "SELECT * FROM inventory_requests_tbl WHERE request_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Fetch Request Data. Please Contact the Programmer.",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $requestId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Fetch Request Data. Please Contact the Programmer.",
            "data" => $stmt->error
        ]);
    } else {
        $result = $stmt->get_result();
        $requestData = $result->fetch_assoc();
        // ? Store Data to variables
        $requestType = $requestData['request_name'];
        $requestedAsset = $requestData['requested_asset_id'];
        $requestorId = $requestData['requestor_id'];

        // ? Check Type of Request
        if ($requestType == "Unretire") {
            // ! If Request Type is Unretire
            $checkRepairSql = "SELECT COUNT(*) FROM inventory_repairs_tbl WHERE `repaired_item` = ?;";
            $checkRepairStmt = $conn->prepare($checkRepairSql);

            if (!$checkRepairStmt) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Accept Request. Please Contact the Programmer.",
                    "data" => $conn->error
                ]);
            } else {
                $checkRepairStmt->bind_param("i", $requestedAsset);
                if (!$checkRepairStmt->execute()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "status" => "internal-error",
                        "message" => "Failed to Accept Request. Please Contact the Programmer",
                        "data" => $checkRepairStmt->error
                    ]);
                } else {
                    $checkRepairResult = $checkRepairStmt->get_result();
                    $checkRepairRow = $checkRepairResult->fetch_assoc();
                    $isRepaired = $checkRepairRow['COUNT(*)'];
                    $assetStatus = "Active";

                    if ($isRepaired == 0) {
                        $assetStatus = "Active";
                    } else {
                        $assetStatus = "Repaired";
                    }

                    $unretireSql = "UPDATE inventory_records_tbl SET status = ? WHERE id = ?";
                    $unretireStmt = $conn->prepare($unretireSql);
                    if (!$unretireStmt) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            "status" => "internal-error",
                            "message" => "Failed to Accept Request. Please Contact the Programmer",
                            "data" => $conn->error
                        ]);
                    } else {
                        $unretireStmt->bind_param("si", $assetStatus, $requestedAsset);
                        if (!$unretireStmt->execute()) {
                            header('Content-Type: application/json');
                            echo json_encode([
                                "status" => "internal-error",
                                "message" => "Failed to Accept Request. Please Contact the Programmer",
                                "data" => $unretireStmt->error
                            ]);
                        } else {
                            $isEdited = true;
                        }
                    }
                }
            }
        } else if ($requestType == "Edit FA Number") {
            // ! If Request Type is FA Edit
            $newFa = $requestData['new_fa_number'];

            $editFaSql = "UPDATE inventory_records_tbl SET fa_number = ? WHERE id = ?";
            $editFaStmt = $conn->prepare($editFaSql);
            if (!$editFaStmt) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Accept Request. Please Contact the Programmer",
                    "data" => $conn->error
                ]);
            } else {
                $editFaStmt->bind_param("si", $newFa, $requestedAsset);
                if (!$editFaStmt->execute()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "status" => "internal-error",
                        "message" => "Failed to Accept Request. Please Contact the Programmer",
                        "data" => $editFaStmt->error
                    ]);
                } else {
                    $isEdited = true;
                }
            }
        } else if ($requestType == "Absolute Delete") {
            // ! If Request Type is Absolute Delete
            $deleteFromRepairsSql = "DELETE FROM inventory_repairs_tbl WHERE `repaired_item` = ?";
            $deleteFromRequestsSql = "DELETE FROM inventory_requests_tbl WHERE requested_asset_id = ?";
            $deleteFromDisposedSql = "DELETE FROM inventory_disposed_items_tbl WHERE `inventory_id` = ?";
            $deleteFromDisposalSql = "DELETE FROM inventory_disposal_tbl WHERE `inventory_id` = ?";
            $deleteFromRecordsSql = "DELETE FROM inventory_records_tbl WHERE id = ?";

            $deleteFromRepairsStmt = $conn->prepare($deleteFromRepairsSql);
            if (!$deleteFromRepairsStmt) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Accept Request. Please Contact the Programmer",
                    "data" => $conn->error
                ]);
            } else {
                $deleteFromRepairsStmt->bind_param("i", $requestedAsset);
                if (!$deleteFromRepairsStmt->execute()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "status" => "internal-error",
                        "message" => "Failed to Accept Request. Please Contact the Programmer",
                        "data" => $deleteFromRepairsStmt->error
                    ]);
                } else {
                    $deleteFromRequestsStmt = $conn->prepare($deleteFromRequestsSql);
                    if (!$deleteFromRequestsStmt) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            "status" => "internal-error",
                            "message" => "Failed to Accept Request. Please Contact the Programmer",
                            "data" => $conn->error
                        ]);
                    } else {
                        $deleteFromRequestsStmt->bind_param("i", $requestedAsset);
                        if (!$deleteFromRequestsStmt->execute()) {
                            header('Content-Type: application/json');
                            echo json_encode([
                                "status" => "internal-error",
                                "message" => "Failed to Accept Request. Please Contact the Programmer",
                                "data" => $deleteFromRequestsStmt->error
                            ]);
                        } else {
                            $deleteFromDisposedStmt = $conn->prepare($deleteFromDisposedSql);
                            if (!$deleteFromDisposedStmt) {
                                header('Content-Type: application/json');
                                echo json_encode([
                                    "status" => "internal-error",
                                    "message" => "Failed to Accept Request. Please Contact the Programmer",
                                    "data" => $conn->error
                                ]);
                            } else {
                                $deleteFromDisposedStmt->bind_param("i", $requestedAsset);
                                if (!$deleteFromDisposedStmt->execute()) {
                                    header('Content-Type: application/json');
                                    echo json_encode([
                                        "status" => "internal-error",
                                        "message" => "Failed to Accept Request. Please Contact the Programmer",
                                        "data" => $deleteFromDisposedStmt->error
                                    ]);
                                } else {
                                    $deleteFromDisposalStmt = $conn->prepare($deleteFromDisposalSql);
                                    if (!$deleteFromDisposalStmt) {
                                        header('Content-Type: application/json');
                                        echo json_encode([
                                            "status" => "internal-error",
                                            "message" => "Failed to Accept Request. Please Contact the Programmer",
                                            "data" => $conn->error
                                        ]);
                                    } else {
                                        $deleteFromDisposalStmt->bind_param("i", $requestedAsset);
                                        if (!$deleteFromDisposalStmt->execute()) {
                                            header('Content-Type: application/json');
                                            echo json_encode([
                                                "status" => "internal-error",
                                                "message" => "Failed to Accept Request. Please Contact the Programmer",
                                                "data" => $deleteFromDisposalStmt->error
                                            ]);
                                        } else {
                                            $deleteFromRecordsStmt = $conn->prepare($deleteFromRecordsSql);
                                            if (!$deleteFromRecordsStmt) {
                                                header('Content-Type: application/json');
                                                echo json_encode([
                                                    "status" => "internal-error",
                                                    "message" => "Failed to Accept Request. Please Contact the Programmer",
                                                    "data" => $conn->error
                                                ]);
                                            } else {
                                                $deleteFromRecordsStmt->bind_param("i", $requestedAsset);
                                                if (!$deleteFromRecordsStmt->execute()) {
                                                    header('Content-Type: application/json');
                                                    echo json_encode([
                                                        "status" => "internal-error",
                                                        "message" => "Failed to Accept Request. Please Contact the Programmer",
                                                        "data" => $deleteFromRecordsStmt->error
                                                    ]);
                                                } else {
                                                    header('Content-Type: application/json');
                                                    echo json_encode([
                                                        "status" => "success",
                                                        "message" => "Request Accepted Successfully!",
                                                        "data" => [
                                                            "requestType" => $requestType,
                                                            "requestorId" => $requestorId
                                                        ]
                                                    ]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if ($isEdited) {
        $updateRequestStatusSql = "UPDATE inventory_requests_tbl SET request_status = ? WHERE request_id = ?";
        $updateRequestStatusStmt = $conn->prepare($updateRequestStatusSql);
        $newRequestStatus = "accepted";
        if (!$updateRequestStatusStmt) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to Accept Request. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $updateRequestStatusStmt->bind_param("si", $newRequestStatus, $requestId);
            if (!$updateRequestStatusStmt->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Accept Request. Please Contact the Programmer",
                    "data" => $updateRequestStatusStmt->error
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Request Accepted Successfully!",
                    "data" => [
                        "requestType" => $requestType,
                        "requestorId" => $requestorId,
                        "requestedAsset" => $requestedAsset
                    ],
                ]);
            }
        }
    }
}
// ? Update Request Status to Accepted
