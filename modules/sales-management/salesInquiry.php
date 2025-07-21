<?php
session_start();

require('../../vendor/autoload.php');
require('../../backend/dbconn.php');
require('../../backend/middleware/pipes.php');
require('../../backend/middleware/authorize.php');

if (authorize(true, $conn)) {
    $authId = $_SESSION['user']['id'];
    $authUsername = $_SESSION['user']['username'];
    $authFullName = $_SESSION['user']['full_name'];
    $authRole = $_SESSION['user']['role'];
    $authPP = $_SESSION['user']['profile_picture'];
    $authDepartment = $_SESSION['user']['department'];

    $authorizations = setAuthorizations($_SESSION['user']);
} else {
    header("Location: ../../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sales Management</title>

    <!-- <link rel="stylesheet" href="http://172.16.14.44/dependencies/css/bootstrap/v5.3.3/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="http://172.16.14.44/dependencies/javascript/sweetalert2-11.14.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/sb-admin-2.css">
    <link rel="stylesheet" href="../../../assets/vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../assets/css/custom/global.css"> -->
    <?php include "../components/shared/external-css-import.php" ?>
    <link rel="stylesheet" href="../../assets/css/custom/sales-management/salesInquiry.css">
    <link rel="stylesheet" href="../../assets/css/custom/sales-management/salesProspectInfo.css">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "../components/shared/sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../components/shared/topbar.php" ?>
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-2 text-gray-800">Sales Inquiry</h1>
                        <div id="inquiryAlertsBtnGroup">
                            <i class="fa-solid fa-bell-exclamation text-primary fa-xl mr-4" role="button" data-bs-toggle="modal" data-bs-target="#inquiryAlerts" id="viewInquiryAlertsButton"></i>
                            <div id="newAlertsCount" class="d-none"></div>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Inquiries</h6>
                            <div class="actions d-flex flex-row-reverse gap-3">
                                <button class="btn btn-sm shadow-sm btn-primary createInquiryFormBtn" id="createInquiryBtn" data-bs-toggle="modal" data-bs-target="#createInquiryModal">
                                    <i class="fas fa-circle-plus"></i> Create Inquiry
                                </button>
                                <button class="btn btn-sm shadow-sm btn-success viewInquiryBtn" id="viewInquiryBtn" data-bs-toggle="modal" data-bs-target="#viewInquiryModal">
                                    <i class=" fas fa-paperclip"></i> Inquiries
                                </button>
                                <button class="btn btn-sm shadow-sm btn-warning viewDemographicsBtn" id="viewDemographicsBtn" data-bs-toggle="modal" data-bs-target="#viewDemographicsModal">
                                    <i class="fas fa-chart-simple"></i> Demographics
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-85 py-2" data-bs-toggle="modal" data-bs-target="#prospectTypeHotModal" role="button">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Hot Clients</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="prospectType_hot">
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-fire fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-85 py-2" data-bs-toggle="modal" data-bs-target="#prospectTypeWarmModal" role="button">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Warm Clients</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="prospectType_warm">
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-mitten fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-85 py-2" data-bs-toggle="modal" data-bs-target="#prospectTypeColdModal" role="button">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Cold Clients</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="prospectType_cold">
                                                    </div>
                                                </div>
                                                <div class=" col-auto">
                                                    <i class="fas fa-snowflake fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-secondary shadow h-85 py-2" data-bs-toggle="modal" data-bs-target="#prospectTypeLostModal" role="button">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                        Lost Clients</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="prospectType_lost">
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-person-circle-question fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3" role="button">
                            <h6 class="m-0 font-weight-bold text-primary"> Sales Inquiries Chart</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="prospectType_Chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <?php include "../components/sales-management/createInquiryModal.php" ?>
    <?php include "../components/sales-management/reviewInquiryModal.php" ?>
    <?php include "../components/sales-management/viewDemographicsModal.php" ?>
    <?php include "../components/sales-management/viewInquiryModal.php" ?>
    <?php include "../components/sales-management/viewInquiryModalDetails.php" ?>
    <?php include "../components/sales-management/getprospectTypeHotModal.php" ?>
    <?php include "../components/sales-management/getprospectTypeWarmModal.php" ?>
    <?php include "../components/sales-management/getProspectTypeColdModal.php" ?>
    <?php include "../components/sales-management/getProspectTypeLostModal.php" ?>
    <?php include "../components/sales-management/inquiryAlertsModal.php" ?>
</body>
<?php include '../components/shared/external-js-import.php'; ?>
<script src="../../assets/js/sales-management/createInquiry.js"></script>
<script src="../../assets/js/sales-management/reviewInquiry.js"></script>
<script src="../../assets/js/sales-management/getInquiries.js"></script>
<script src="../../assets/js/sales-management/viewDemographics.js"></script>
<script src="../../assets/js/sales-management/getProspectData.js"></script>
<script src="../../assets/js/sales-management/getSalesChart.js"></script>
<script src="../../assets/js/sales-management/viewInquiryDetails.js"></script>
<script src="../../assets/js/sales-management/viewProspectType.js"></script>

</html>