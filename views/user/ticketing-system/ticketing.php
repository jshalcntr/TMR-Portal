<?php
session_start();

require('../../../backend/auth.php');
require('../../../backend/dbconn.php');
require('../../../backend/middleware/pipes.php');
require('../../../backend/middleware/authorize.php');

if (authorize($_SESSION['user']['role'] == "USER" || $_SESSION['user']['role'] == "HEAD")) {
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

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom styles for this template-->
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../assets/vendor/jquery/jquery-ui.css" rel="stylesheet">

    <link rel="stylesheet" href="../../../assets/css/custom/global.css">
    <link rel="stylesheet" href="../../../assets/css/custom/user/dashboard.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "../../components/sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include "../../components/topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <!-- Begin Ticket Form -->
                        <div class="<?= $divsize ?>">
                            <div class="card card-body shadow">
                                <form id="ticketForm" enctype="multipart/form-data">
                                    <h3>New Ticket</h3>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <!-- <input type="text" name="ticket_category" id="ticket_category" class="form-control" placeholder="Category" required> -->

                                            <?php include "../../../backend/user/ticketing-system/ticketcategory.php" ?>

                                            <select name="ticket_category" id="ticket_category" class="form-control" required>
                                                <option value="" disabled selected>Select a Category</option>
                                                <?php foreach ($categories as $mainCategory => $subCategories): ?>
                                                    <optgroup label="<?php echo htmlspecialchars($mainCategory); ?>">
                                                        <?php foreach ($subCategories as $subCategory): ?>
                                                            <option value="<?php echo htmlspecialchars($subCategory); ?>">
                                                                <?php echo htmlspecialchars($subCategory); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="text" name="ticket_subject" id="ticket_subject" class="form-control" placeholder="Subject" required>

                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <textarea name="ticket_content" id="ticket_content" class="form-control" rows="5" placeholder="Description" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="ticket_attachment">Attachment</label>
                                            <input type="file" name="ticket_attachment" id="ticket_attachment" class="form-control-file">
                                            <small class="form-text text-muted">Allowed file types: .jpg, .png, .pdf, .docx</small>
                                            <div id="file-error" class="text-danger mt-1"></div>
                                        </div>
                                    </div>
                                    <!-- Success/Error Message -->
                                    <div id="form-message" class="text-center"></div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 text-right">
                                            <button type="submit" name="submit_ticket" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--End of Ticket Form-->
                        <!-- Heads for approval ticket -->
                        <div class="<?= $divsize . $divhidden ?>">
                            <div class="card card-body shadow">
                                <h3 class="page-header">For Approval</h3>
                                <button class="dropdown-item align-items-center">
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Ticket Title</div>
                                        <div class="small text-gray-500 text-truncate">Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <!-- End of for approval ticket -->
                        <!-- Pending Tickets -->
                        <div class="<?= $divsize ?>">
                            <div class="card card-body shadow">
                                <h3 class="page-header">3 Tickets Pending</h3>
                                <button class="dropdown-item align-items-center">
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Ticket Title</div>
                                        <div class="small text-gray-500 text-truncate">Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <!-- End of pending tickets -->
                        <!-- ticket history -->
                        <div class="<?= $divsize ?>">
                            <div class="card card-body shadow">
                                <h3 class="page-header">My Ticket History</h3>
                                <button class="dropdown-item align-items-center">
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Ticket Title</div>
                                        <div class="small text-gray-500 text-truncate">Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="similar-ticket card card-body shadow hidden"></div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


</body>
<!-- Bootstrap core JavaScript-->
<script src="../../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../../assets/vendor/jquery/jquery-ui.min.js"></script>
<script src="../../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../../assets/js/sb-admin-2.js"></script>
<script src="../../../assets/js/user/ticketing-system/userTicketing.js"></script>
<script src="../../../assets/js/user/ticketing-system/addTicket.js"></script>
<!-- <script src="../../../assets/js/user/ticketing-system/ticket-cetegory.js"></script> -->

</html>