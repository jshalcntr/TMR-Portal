<?php
session_start();

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

    <!-- Custom styles for this template-->
    <link href="../../../assets/css/sb-admin-2.css" rel="stylesheet">

    <link rel="stylesheet" href="../../../assets/css/custom/global.css">

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
                        <div class="col-md-4 card card-body shadow">
                            <form action="" method="post">
                                <h3>New Ticket</h3>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <select name="ticket_category" id="ticket_category" class="form-control form-select" required>
                                            <option value="" disabled selected style="display: none; color:#6e6c6b;">Category</option>
                                            
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
                                    <div class="form-group col-md-12 text-right">
                                        <button type="submit" name="submit_ticket" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--End of Ticket Form-->

                        <div class="col-md-4 card card-body shadow">
                            <h3 class="page-header">3 Tickets Pending</h3>
                            <button class="dropdown-item align-items-center" >
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Ticket Title</div>
                                    <div class="small text-gray-500 text-truncate">Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, Ticket description, </div>
                                </div>
                            </button>
                        </div>
                    </div>

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
<script src="../../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../../../assets/js/sb-admin-2.js"></script>
<script src="../../../assets/js/user/ticketing-system/userTicketing.js"></script>

</html>