<?php
include("connections.php");

// Fetch all records from the database
$query_all = "SELECT * FROM `2222`";
$result_all = mysqli_query($connections, $query_all);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="Cross-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="thanie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="logout-confirm.js"></script>
    <script src="status_functions.js"></script>
    <script src="refresh_status.js"></script>

    



</head>
<body>

<div class="vertical-tab">

    <img class="logotitle" src="logoto.png">
    <b style="display: flex; align-items: center;">
        <a href="admin.php" class="active">
            <i class="fas fa-tachometer-alt" style="margin-right: 5px;"></i>
            Dashboard
        </a>
    </b>


      
    <p style="color: grey;">MODULES</p>

    <div>
        <a href="add_vehicle.php">
            <i class="fas fa-car" style="margin-right: 5px;"></i>
            Add Vehicle
        </a>
    </div>
    <div>
        <a href="status.php">
            <i class="fas fa-list" style="margin-right: 5px;"></i>
            Status list
        </a>
    </div>
    <div> 
        <b>
            <a href="#">
                <i class="fas fa-cog" style="margin-right: 5px;"></i>
                Settings
            </a>
        </b>
        <b>
            <a href="login.php" onclick="return confirmLogout();">
        <i class="fas fa-sign-out-alt"></i>
        Log out
    </a>
        </b>
    </div>
    <br>
</div>

<!-- Footer -->
<footer class="footer1">
        
    <div class="footer-section">
    <br>
         <a href="#" style="margin-right: 980px";><b>● Vehicle reservation</a></b>
         
        <a href="#">● Terms and Conditions</a>
        <a href="#">● Privacy Policy</a>
    </div>
    <div class="footer-section">
    <br>
        <a href="#">● Contacts</a>
        <a href="#">● About Us</a>
    </div>
    
    
</footer>
            

    <div class="container" style="margin-left: 280px;">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <br><br><br>
                    </div>
                    <center>
                        <div class="card-body">
                            
                            <button onclick="filterRecords('Pending')">Pending</button>
                            <button onclick="filterRecords('Approved')">Approved</button>
                            <button onclick="filterRecords('Rejected')">Rejected</button>
                            <button onclick="refreshData()">Show All</button>

                            
                            <?php
                            if (isset($_GET['status'])) {
                                $status = $_GET['status'];
                                $query = "SELECT * FROM `2222` WHERE Status = ?";
                                $stmt = mysqli_prepare($connections, $query);
                                mysqli_stmt_bind_param($stmt, 's', $status);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    echo "<h2>$status Records</h2>";
                                    echo "<table class='text-center'>";
                                    echo "<tr class='tr1'>";
                                    echo "<td>Reservation ID</td>";
                                    echo "<td>Vehicle type</td>";
                                    echo "<td>Vehicle color</td>";
                                    echo "<td>Vehicle brand</td>";
                                    echo "<td>Plate number</td>";
                                    echo "<td>Time</td>";
                                    echo "<td>Date</td>";
                                    echo "<td>Status</td>";
                                    echo "</tr>";
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>".$row['Reservation_id']."</td>";
                                        echo "<td>".$row['Vehicle_type']."</td>";
                                        echo "<td>".$row['Vehicle_color']."</td>";
                                        echo "<td>".$row['Vehicle_brand']."</td>";
                                        echo "<td>".$row['Plate_no']."</td>";
                                        echo "<td>".$row['Time']."</td>"; 
                                        echo "<td>".$row['Date']."</td>";
                                        echo "<td>".$row['Status']."</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    echo "<p>No records found for $status</p>";
                                }
                            } else {
                                
                                if ($result_all && mysqli_num_rows($result_all) > 0) {
                                    echo "<h2>All Records</h2>";
                                    echo "<table class='text-center'>";
                                    echo "<tr class='tr1'>";
                                    echo "<td>Reservation ID</td>";
                                    echo "<td>Vehicle type</td>";
                                    echo "<td>Vehicle color</td>";
                                    echo "<td>Vehicle brand</td>";
                                    echo "<td>Plate number</td>";
                                    echo "<td>Time</td>";
                                    echo "<td>Date</td>";
                                    echo "<td>Status</td>";
                                    echo "</tr>";
                                    while($row = mysqli_fetch_assoc($result_all)) {
                                        echo "<tr>";
                                        echo "<td>".$row['Reservation_id']."</td>";
                                        echo "<td>".$row['Vehicle_type']."</td>";
                                        echo "<td>".$row['Vehicle_color']."</td>";
                                        echo "<td>".$row['Vehicle_brand']."</td>";
                                        echo "<td>".$row['Plate_no']."</td>";
                                        echo "<td>".$row['Time']."</td>"; 
                                        echo "<td>".$row['Date']."</td>";
                                        echo "<td>".$row['Status']."</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    echo "<p>No records found</p>";
                                }
                            }
                            ?>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>
