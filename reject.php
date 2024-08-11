<?php
// Logic to remove the reservation goes here

// Show a prompt message
echo "<script>alert('Reservation rejected!');</script>";

// Redirect to the status page
echo "<script>window.location.href = 'status.php';</script>";
exit(); // Make sure to exit after redirection

