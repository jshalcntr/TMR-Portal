<?php
function authorize($condition)
{
    if (!isset($_SESSION['user']) && $condition) {
        header("Location: ../../index.php");
    }
}

function setAuthorizations($user)
{
    return array(
        "inventory_view" => $_SESSION['user']["inventory_view_auth"],
        "inventory_edit" => $_SESSION['user']["inventory_edit_auth"],
    );
}
