<?php
function authorize($condition)
{
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
