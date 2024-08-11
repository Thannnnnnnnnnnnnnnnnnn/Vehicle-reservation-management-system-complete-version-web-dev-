<?php
include("connections.php");

if(isset($_GET['id'])) {
    $reservation_id = $_GET['id'];
    
    
    $query = "UPDATE `table` SET Status = 'Approved' WHERE Reservation_id = $reservation_id";
    $result = mysqli_query($connections, $query);
    
    
    header("Location: admin.php");
    exit();
}
?>
