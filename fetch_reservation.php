<?php

include("connections.php");


if(isset($_GET['id'])) {
   
    $reservation_id = $_GET['id'];

   
    $query = "SELECT * FROM `table` WHERE Reservation_id = ?";
    $stmt = $connections->prepare($query);

   
    $stmt->bind_param("i", $reservation_id);

 
    $stmt->execute();

  
    $result = $stmt->get_result();

    
    if($result->num_rows > 0) {
        
        $reservation = $result->fetch_assoc();

       
        echo "<h1>Reservation Details</h1>";
        echo "<p>Reservation ID: " . $reservation['Reservation_id'] . "</p>";
        echo "<p>Vehicle Type: " . $reservation['Vehicle_type'] . "</p>";
        echo "<p>Vehicle Color: " . $reservation['Vehicle_color'] . "</p>";
        echo "<p>Vehicle Brand: " . $reservation['Vehicle_brand'] . "</p>";
        echo "<p>Plate Number: " . $reservation['Plate_no'] . "</p>";
        echo "<p>Time: " . $reservation['Time'] . "</p>";
        echo "<p>Date: " . $reservation['Date'] . "</p>";
        echo "<p>Status: " . $reservation['Status'] . "</p>";
    } else {
       
        echo "<p>No reservation found with the provided ID.</p>";
    }
  
    $stmt->close();
} else {
    
    echo "<p>No Reservation ID provided.</p>";
}
?>
