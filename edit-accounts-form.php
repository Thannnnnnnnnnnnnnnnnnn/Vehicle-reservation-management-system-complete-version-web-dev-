<?php
include("connections.php");

if (isset($_GET['id'])) {
    $tableID = $_GET['id'];
    
    $query = "SELECT * FROM `accounts` WHERE tbl_id = ?";
    $stmt = mysqli_prepare($connections, $query);
    mysqli_stmt_bind_param($stmt, "i", $tableID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $html = "<form id='edit-form'>";
            $html .= "<input type='hidden' name='edit-id' value='{$row['tbl_id']}'>";
            $html .= "<div class='mb-3'>";
            $html .= "<label for='edit-email' class='form-label'>Email</label>";
            $html .= "<input type='email' class='form-control' id='edit-email' name='edit-email' value='{$row['Email']}'>";
            $html .= "</div>";
            $html .= "<div class='mb-3'>";
            $html .= "<label for='edit-password' class='form-label'>Password</label>";
            $html .= "<input type='password' class='form-control' id='edit-password' name='edit-password' value='{$row['password']}'>";
            $html .= "</div>";
            $html .= "<div class='mb-3'>";
            $html .= "<label for='edit-account-type' class='form-label'>Account Type</label>";
            $html .= "<input type='text' class='form-control' id='edit-account-type' name='edit-account-type' value='{$row['account_type']}'>";
            $html .= "</div>";
            $html .= "<div class='mb-3'>";
            $html .= "<label for='edit-contact-no' class='form-label'>Contact No.</label>";
            $html .= "<input type='text' class='form-control' id='edit-contact-no' name='edit-contact-no' value='{$row['Contact_No']}'>";
            $html .= "</div>";
            $html .= "<div class='mb-3'>";
            $html .= "<label for='edit-firstname' class='form-label'>First Name</label>";
            $html .= "<input type='text' class='form-control' id='edit-firstname' name='edit-firstname' value='{$row['Firstname']}'>";
            $html .= "</div>";
            $html .= "<div class='mb-3'>";
            $html .= "<label for='edit-lastname' class='form-label'>Last Name</label>";
            $html .= "<input type='text' class='form-control' id='edit-lastname' name='edit-lastname' value='{$row['Lastname']}'>";
            $html .= "</div>";
            $html .= "<button type='submit' class='add-button'>Save Changes </button>  " ;
            
            $html .= "<button type='button' class='close-button' data-bs-dismiss='modal'>Close</button>";
            $html .= "</form>";
            echo $html;
        } else {
            echo "No record found with the provided ID.";
        }
    } else {
        echo "Query execution failed.";
    }
} else {
    echo "No record ID provided.";
}
?>
<link rel="stylesheet" href="buttons.css">