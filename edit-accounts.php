<?php
// Include your database connection
include("connections.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $caseId = $_POST['edit-case-id'];
    $vehicleType = $_POST['edit-case-vehicle-type'];
    $vehicleColor = $_POST['edit-case-vehicle-color'];
    $vehicleBrand = $_POST['edit-case-vehicle-brand'];
    $vehiclePlate = $_POST['edit-case-vehicle-plate'];
    

    
    $query = "UPDATE `table` SET Vehicle_type=?, Vehicle_color=?, Vehicle_brand=?, Plate_no=? WHERE Reservation_id=?";
    
   
    $stmt = mysqli_prepare($connections, $query);

    
    mysqli_stmt_bind_param($stmt, "ssssi", $vehicleType, $vehicleColor, $vehicleBrand, $vehiclePlate, $caseId);

   
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
       
        echo json_encode(array('success' => true));
        exit();
    } else {
        
        echo json_encode(array('success' => false));
        exit();
    }
}
?>
