<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TMR Internal Portal</title>

    <?php include "views/components/external-css-import.php" ?>

    <link rel="stylesheet" href="assets/css/custom/login.css">

</head>

<body class="bg-gradient-primary">
    <div id="errorModal">
        <!-- <div class="alert alert-danger alert-dismissible text--white fade" role="alert" style="z-index: 1;" id="alert">
            <strong>Invalid Login Credentials!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> -->
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none bg-login-image d-flex justify-content-center align-items-center">
                                <img src="assets/img/tmr-logo.png" alt="" width="250px">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h3 text-gray-900 mb-4">Welcome to<br><span class="h2 font-weight-bold">TMR Internal Portal!</span></h1>
                                    </div>
                                    <form class="user" id="loginForm">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group" style="position: relative;">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" placeholder="Password">
                                            <i class="fa-duotone fa-light fa-eye-slash" id="togglePassword" style="position: absolute; top: 18px; right: 20px; cursor: pointer;"></i>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="http://172.16.14.44/dependencies/javascript/bootstrap/v5.3.3/bootstrap.bundle.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
    -->

    <?php include "views/components/external-js-import.php" ?>
    <script src="assets/js/authenticate.js"></script>
</body>

</html>