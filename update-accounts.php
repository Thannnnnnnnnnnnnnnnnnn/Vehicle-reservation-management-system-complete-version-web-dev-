<?php
include("connections.php");

$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tbl_id = $_POST['edit-id'];
    $Email = $_POST['edit-email'];
    $password = $_POST['edit-password'];
    $account_type = $_POST['edit-account-type'];
    $Contact_No = $_POST['edit-contact-no'];
    $Firstname = $_POST['edit-firstname'];
    $Lastname = $_POST['edit-lastname'];

    $query = "UPDATE `accounts` SET Email = ?, password = ?, account_type = ?, Contact_No = ?, Firstname = ?, Lastname = ? WHERE tbl_id = ?";
    $stmt = mysqli_prepare($connections, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $Email, $password, $account_type, $Contact_No, $Firstname, $Lastname, $tbl_id);

    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
    } else {
        $response['error'] = mysqli_error($connections);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($connections);

echo json_encode($response);
?>
