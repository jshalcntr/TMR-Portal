<?php
function authorize($condition, $conn)
{
    $accountId = $_SESSION['user']['id'];
    $sql = "SELECT accounts_tbl.id,
                    accounts_tbl.username,
                    accounts_tbl.password,
                    accounts_tbl.full_name,
                    accounts_tbl.role,
                    accounts_tbl.profile_picture,
                    accounts_tbl.department,
                    accounts_tbl.status,
                    authorizations_tbl.*
                    FROM accounts_tbl
                    JOIN authorizations_tbl ON accounts_tbl.id = authorizations_tbl.account_id
                    WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `There's an error occurred while fetching account details. Please contact MIS.`,
                    });
                })
            })
        </script>";
    } else {
        $stmt->bind_param("i", $accountId);
        $stmt->execute();
        $result = $stmt->get_result();
        $account = $result->fetch_assoc();
        if ($_SESSION['user']['password'] == $account['password']) {
            $_SESSION['user'] = $account;
        } else {
            session_destroy();
            header("Location:/tmr-portal_dev/index.php");
        }
    }
    return isset($_SESSION['user']) && $condition;
}
function setAuthorizations($user)
{
    return array(
        "inventory_view" => $_SESSION['user']["inventory_view_auth"],
        "inventory_edit" => $_SESSION['user']["inventory_edit_auth"],
        "accounts_view" => $_SESSION['user']["accounts_view_auth"],
        "accounts_edit" => $_SESSION['user']["accounts_edit_auth"],
    );
}
