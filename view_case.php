<?php

include("connections.php");

if(isset($_GET['id'])) {
    $caseId = $_GET['id'];
    
    $query = "SELECT * FROM `table` WHERE Reservation_id = ?";
    
    $stmt = mysqli_prepare($connections, $query);
    mysqli_stmt_bind_param($stmt, "i", $caseId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($result) {
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            echo "<b><p>Reservation ID:</b> " . $row['Reservation_id'] . "</p>";
            echo "<b><p>Vehicle Type:</b> " . $row['Vehicle_type'] . "</p>";
            echo "<b><p>Vehicle Color:</b> " . $row['Vehicle_color'] . "</p>";
            echo "<b><p>Vehicle Brand:</b> " . $row['Vehicle_brand'] . "</p>";
            echo "<b><p>Time:</b> " . $row['Time'] . "</p>";
            echo "<b><p>Date:</b> " . $row['Date'] . "</p>";
            echo "<b><p>Status:</b> " . $row['Status'] . "</p>";
            if (!empty($row['Plate_image'])) {
                echo "<b><p>Plate Image:</b> <img src='image/" . basename($row['Plate_image']) . "' alt='Plate Image' width='300' height='150'></p>";
            } else {
                echo "<b><p>Plate No.:</b> " . $row['Plate_no'] . "</p>";
            }
            
        } else {
            echo "No case found with the provided ID.";
        }
    } else {
        echo "Query execution failed.";
    }
} else {
    echo "No case ID provided.";
}
?>
