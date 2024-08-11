<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $reservationId = $_POST['Reservation_id'];
    $vehicleType = $_POST['Vehicle_type'];
    $vehicleColor = $_POST['Vehicle_color'];
    $vehicleBrand = $_POST['Vehicle_brand'];
    $plateNo = $_POST['Plate_no'];
    $date = $_POST['Date'];
    $status = $_POST['Status'];

   
    include("connections.php");
    
    $sql = "UPDATE `account` SET Vehicle_type=?, Vehicle_color=?, Vehicle_brand=?, Plate_no=?, Date=?, Status=? WHERE Reservation_id=?";
    
    $stmt = mysqli_prepare($connections, $sql);
    
    mysqli_stmt_bind_param($stmt, "ssssssi", $vehicleType, $vehicleColor, $vehicleBrand, $plateNo, $date, $status, $reservationId);
    
    if (mysqli_stmt_execute($stmt)) {
       
        header("Location: admin.php");
        exit();
    } else {
        
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connections);
} else {
   
    header("Location: edit.php?id=" . $_POST['Reservation_id']);
    exit();
}
?>
