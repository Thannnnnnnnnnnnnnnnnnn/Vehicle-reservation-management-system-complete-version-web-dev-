<?php
include("connections.php");

if (isset($_GET['id'])) {
    $tbl_id = $_GET['id'];
    
    // Prepare a delete statement
    $query = "DELETE FROM `accounts` WHERE tbl_id = ?";
    $stmt = mysqli_prepare($connections, $query);
    mysqli_stmt_bind_param($stmt, "i", $tbl_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the admin page after successful deletion
        header("Location: accounts.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($connections);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "No ID provided.";
}

mysqli_close($connections);
?>
