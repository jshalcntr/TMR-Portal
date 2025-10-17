<?php
require('../dbconn.php');
session_start();
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "SELECT * FROM backorders_tbl WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        // Format dates
        $orderDate = !empty($result['order_date']) ? date('m/d/Y', strtotime($result['order_date'])) : '—';
        $eta1 = !empty($result['eta_1']) ? date('m/d/Y', strtotime($result['eta_1'])) : '—';
        $eta2 = !empty($result['eta_2']) ? date('m/d/Y', strtotime($result['eta_2'])) : '—';
        $eta3 = !empty($result['eta_3']) ? date('m/d/Y', strtotime($result['eta_3'])) : '—';
        $deliveryDate = !empty($result['delivery_date']) ? date('m/d/Y', strtotime($result['delivery_date'])) : '—';

        // Calculate total
        $total = $result['qty'] * $result['bo_price'];

        // Calculate aging
        $aging = '—';
        if (!empty($result['eta_1'])) {
            $orderDateObj = new DateTime($result['order_date']);
            $eta1Obj = new DateTime($result['eta_1']);

            $today = new DateTime();
            if ($today <= $eta1Obj) {
                $finalEta = $eta1Obj;
            } else {
                $eta2Obj = (clone $eta1Obj)->modify('+15 days');
                $finalEta = $eta2Obj;
                if ($today > $eta2Obj) {
                    $eta3Obj = (clone $eta2Obj)->modify('+15 days');
                    $finalEta = $eta3Obj;
                }
            }

            $interval = $orderDateObj->diff($finalEta);
            $parts = [];
            if ($interval->y > 0) $parts[] = $interval->y . " year" . ($interval->y > 1 ? "s" : "");
            if ($interval->m > 0) $parts[] = $interval->m . " month" . ($interval->m > 1 ? "s" : "");
            if ($interval->d > 0 || empty($parts)) $parts[] = $interval->d . " day" . ($interval->d > 1 ? "s" : "");
            $aging = implode(", ", $parts);
        }

        echo "
        <div class='row'>
            <div class='col-md-6'>
                <div class='card border-0'>
                    <div class='card-header bg-primary text-white'>
                        <h6 class='mb-0'><i class='fas fa-info-circle'></i> Order Information</h6>
                    </div>
                    <div class='card-body'>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>RO Number:</strong></div>
                            <div class='col-7'>{$result['ro_number']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Customer Name:</strong></div>
                            <div class='col-7'>{$result['customer_name']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Order No:</strong></div>
                            <div class='col-7'>{$result['order_no']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Order Date:</strong></div>
                            <div class='col-7'>{$orderDate}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Source:</strong></div>
                            <div class='col-7'>{$result['source']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Order Status:</strong></div>
                            <div class='col-7'>
                                <span class='badge badge-" . ($result['order_status'] == 'Delivered' ? 'success' : ($result['order_status'] == 'Cancelled' ? 'danger' : 'warning')) . "'>
                                    {$result['order_status']}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-md-6'>
                <div class='card border-0'>
                    <div class='card-header bg-info text-white'>
                        <h6 class='mb-0'><i class='fas fa-cogs'></i> Part Details</h6>
                    </div>
                    <div class='card-body'>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Part Number:</strong></div>
                            <div class='col-7'>{$result['part_number']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Part Name:</strong></div>
                            <div class='col-7'>{$result['part_name']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Quantity:</strong></div>
                            <div class='col-7'>{$result['qty']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>BO Price:</strong></div>
                            <div class='col-7'>₱" . number_format($result['bo_price'], 2) . "</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Total:</strong></div>
                            <div class='col-7'><strong>₱" . number_format($total, 2) . "</strong></div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Aging:</strong></div>
                            <div class='col-7'>{$aging}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='row mt-3'>
            <div class='col-md-6'>
                <div class='card border-0'>
                    <div class='card-header bg-warning text-dark'>
                        <h6 class='mb-0'><i class='fas fa-calendar-alt'></i> ETA Information</h6>
                    </div>
                    <div class='card-body'>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>1st ETA:</strong></div>
                            <div class='col-7'>{$eta1}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>2nd ETA:</strong></div>
                            <div class='col-7'>{$eta2}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>3rd ETA:</strong></div>
                            <div class='col-7'>{$eta3}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Delivery Date:</strong></div>
                            <div class='col-7'>{$deliveryDate}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-md-6'>
                <div class='card border-0'>
                    <div class='card-header bg-secondary text-white'>
                        <h6 class='mb-0'><i class='fas fa-tools'></i> Service Information</h6>
                    </div>
                    <div class='card-body'>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Order Type:</strong></div>
                            <div class='col-7'>{$result['order_type']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Service Type:</strong></div>
                            <div class='col-7'>{$result['service_type']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Service Estimator:</strong></div>
                            <div class='col-7'>{$result['service_estimator']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Unit/Model:</strong></div>
                            <div class='col-7'>{$result['unit_model']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Plate No:</strong></div>
                            <div class='col-7'>{$result['plate_no']}</div>
                        </div>
                        <div class='row mb-2'>
                            <div class='col-5'><strong>Unit Status:</strong></div>
                            <div class='col-7'>{$result['unit_status']}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='row mt-3'>
            <div class='col-12'>
                <div class='card border-0'>
                    <div class='card-header bg-dark text-white'>
                        <h6 class='mb-0'><i class='fas fa-comment'></i> Additional Information</h6>
                    </div>
                    <div class='card-body'>
                        <div class='row mb-2'>
                            <div class='col-2'><strong>Remarks:</strong></div>
                            <div class='col-10'>" . (!empty($result['remarks']) ? $result['remarks'] : 'No remarks') . "</div>
                        </div>";

        // Add cancel reason if cancelled
        if ($result['order_status'] == 'Cancelled' && !empty($result['cancel_reason'])) {
            echo "
                        <div class='row mb-2'>
                            <div class='col-2'><strong>Cancel Reason:</strong></div>
                            <div class='col-10 text-danger'>{$result['cancel_reason']}</div>
                        </div>";
        }

        // Add delete reason if deleted
        if ($result['is_deleted'] == 1 && !empty($result['delete_reason'])) {
            echo "
                        <div class='row mb-2'>
                            <div class='col-2'><strong>Delete Reason:</strong></div>
                            <div class='col-10 text-danger'>{$result['delete_reason']}</div>
                        </div>";
        }

        echo "
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .badge {
            font-size: 0.75em;
        }
        </style>";
    } else {
        echo "<div class='alert alert-danger'><i class='fas fa-exclamation-triangle'></i> Record not found.</div>";
    }
}
