<?php
session_start();

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
    header("Location: ../../../index.php");
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

    <title>Invertory Management</title>


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
    <link rel="stylesheet" href="../../assets/css/custom/shared/profile.css">
</head>

<body id="page-top">
    <input type="hidden" name="accountId" id="accountId" value="<?php echo $authId; ?>">
    <div id="wrapper">
        <?php include "../components/shared/sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../components/shared/topbar.php" ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Account Information</h1>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Account</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row" style="width: fit-content; justify-self: center">
                                        <div class="col d-flex justify-content-center align-items-center profile-picture-col">
                                            <img width="256px" class="rounded-circle border border-dark" id="profilePicture" src="../../assets/img/no-profile.png">
                                            <button type="button" class="btn-circle btn-dark" id="editProfilePictureBtn" data-bs-toggle="modal" data-bs-target="#editProfilePictureModal"><i class="fas fa-pencil"></i></button></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <form id="profileInformationForm" class="container-sm needs-validation" novalidate autoccomplete="off">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="fullName_edit" class="col-form-label">Full Name</label>
                                                        <input type="text" name="fullName" id="fullName_edit" class="form-control form-control-sm" value="<?= $authFullName ?>" required disabled>
                                                        <div class="invalid-feedback">
                                                            Full name is required.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1 d-flex align-items-center" id="viewFullNameBtnGroup">
                                                    <button type="button" class="btn-circle btn-sm btn-primary" id="editFullNameBtn"><i class="fas fa-pencil"></i></button></button>
                                                </div>
                                                <div class="col-1 d-none align-items-center" id="editFullNameBtnGroup">
                                                    <button type="submit" class="btn-circle btn-sm btn-primary" id="saveFullNameBtn"><i class="fas fa-check"></i></button></button>
                                                    <button type="button" class="btn-circle btn-sm btn-danger" id="cancelEditFullNameBtn"><i class="fas fa-xmark"></i></button></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <form id="changePasswordForm" class="container-sm needs-validation" novalidate autoccomplete="off">
                                            <div class="col">
                                                <div class="row mb-2">
                                                    <h4>Change Password</h4>
                                                </div>
                                                <div class="row mb-2 form-group" style="position: relative;">
                                                    <label for="currentPassword">Current Password</label>
                                                    <input type="password" name="currentPassword" id="currentPassword" class="form-control form-control-sm" required>
                                                    <div class="invalid-feedback">Please enter your current password</div>
                                                    <i class="fa-duotone fa-light fa-eye-slash" id="toggleCurrentPassword" style="position: absolute; top: 62%; left: 94%; cursor: pointer;"></i>
                                                </div>
                                                <div class="row mb-2 form-group" style="position: relative;">
                                                    <label for="newPassword">New Password</label>
                                                    <input type="password" name="newPassword" id="newPassword" class="form-control form-control-sm" required>
                                                    <!-- <small id="passwordHelp" class="form-text text-muted">
                                                        Must be 8 or more characters long, contain uppercase and lowercase letters, a number, and a special character.
                                                    </small> -->
                                                    <div class="invalid-feedback">New Password does not meet the criteria.</div>
                                                    <i class="fa-duotone fa-light fa-eye-slash" id="toggleNewPassword" style="position: absolute; top: 62%; left: 94%; cursor: pointer;"></i>
                                                </div>
                                                <div class="row mb-2 form-group" style="position: relative;">
                                                    <label for="confirmPassword">Confirm Password</label>
                                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control-sm" required>
                                                    <div class="invalid-feedback">Passwords do not match.</div>
                                                    <i class="fa-duotone fa-light fa-eye-slash" id="toggleConfirmPassword" style="position: absolute; top: 62%; left: 94%; cursor: pointer;"></i>
                                                </div>
                                                <div class="row align-items-end justify-content-end">
                                                    <button type="submit" class="btn btn-primary" style="width: auto;"><i class="fas fa-key"></i> Save Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProfilePictureModal" tabindex="-1" aria-labelledby="editProfilePictureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center px-4">
                    <h3 class="modal-title" id="editProfilePictureModalLabel">Profile Pic</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body px-lg-5 py-3 container d-flex flex-column" id="editProfilePictureModalBody" enctype="multipart/form-data">
                    <div class="row justify-content-center align-items-center" id="dpPreviewRow" style="position: relative;">
                        <label class="d-flex align-items-center justify-content-center" for="profilePictureFile" style="width: auto; cursor: pointer">
                            <img src="" id="dpPreview" class="rounded-circle border border-dark">
                        </label>
                        <a id="removeProfilePicture" class="text-danger fw-bold d-none" style="cursor: pointer; position: absolute; top: 12px; left:73%;">Remove Profile Picture</a>
                    </div>
                    <div class="row justify-content-center align-items-center" id="dpUploadRow">
                        <input class="form-control form-control-sm" type="file" name="profilePictureFile" id="profilePictureFile" accept="image/*" required>
                        <i class="fas fa-link-slash text-danger d-none" id="unattachFile"></i>
                    </div>
                    <div class="row action-row justify-content-end d-none" id="dpSubmitFormBtn">
                        <button type="submit" class="btn btn-sm shadow-sm btn-primary" style="width: auto;"><i class="fas fa-floppy-disk"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<?php include '../components/shared/external-js-import.php'; ?>
<script src="../../assets/js/shared/profile-setting/profile.js"></script>


</html>