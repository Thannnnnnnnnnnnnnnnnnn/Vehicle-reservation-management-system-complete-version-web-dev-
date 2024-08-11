<?php
include("connections.php");
// Than Evora - BSIT - 2222
$sql_approved_count = "SELECT COUNT(*) AS approved_count FROM `table` WHERE Status = 'Approved'";
$result_approved_count = $connections->query($sql_approved_count);
$row_approved_count = $result_approved_count->fetch_assoc();
$approved_count = $row_approved_count['approved_count'];

$sql_rejected_count = "SELECT COUNT(*) AS rejected_count FROM `table` WHERE Status = 'Rejected'";
$result_rejected_count = $connections->query($sql_rejected_count);
$row_rejected_count = $result_rejected_count->fetch_assoc();
$rejected_count = $row_rejected_count['rejected_count'];

$sql_pending_count = "SELECT COUNT(*) AS pending_count FROM `table` WHERE Status = 'Pending'";
$result_pending_count = $connections->query($sql_pending_count);
$row_pending_count = $result_pending_count->fetch_assoc();
$pending_count = $row_pending_count['pending_count'];

$sql_two_wheel_count = "SELECT COUNT(*) AS two_wheel_count FROM `table` WHERE Vehicle_type = '2 Wheel'";
$result_two_wheel_count = $connections->query($sql_two_wheel_count);
$row_two_wheel_count = $result_two_wheel_count->fetch_assoc();
$two_wheel_count = $row_two_wheel_count['two_wheel_count'];

$sql_four_wheel_count = "SELECT COUNT(*) AS four_wheel_count FROM `table` WHERE Vehicle_type = '4 Wheel'";
$result_four_wheel_count = $connections->query($sql_four_wheel_count);
$row_four_wheel_count = $result_four_wheel_count->fetch_assoc();
$four_wheel_count = $row_four_wheel_count['four_wheel_count'];

$sql_vehicle_count = "SELECT COUNT(*) AS vehicle_count FROM `table`";
$result_vehicle_count = $connections->query($sql_vehicle_count);
$row_vehicle_count = $result_vehicle_count->fetch_assoc();
$vehicle_count = $row_vehicle_count['vehicle_count'];

$sql_admin_count = "SELECT COUNT(*) AS admin_count FROM `accounts` WHERE account_type = '1'";
$result_admin_count = $connections->query($sql_admin_count);
$row_admin_count = $result_admin_count->fetch_assoc();
$admin_count = $row_admin_count['admin_count'];


$sql_user_count = "SELECT COUNT(*) AS user_count FROM `accounts` WHERE account_type = '2'";
$result_user_count = $connections->query($sql_user_count);
$row_user_count = $result_user_count->fetch_assoc();
$user_count = $row_user_count['user_count'];

$currentDate = date('Y-m-d');
$sql_recent_reservations = "SELECT * FROM `table`";
$result_recent_reservations = $connections->query($sql_recent_reservations);

$recent_reservations = array();

if ($result_recent_reservations) {
    while ($row = $result_recent_reservations->fetch_assoc()) {
        $recent_reservations[] = $row;
    }
}


$sql_brand_counts = "SELECT Vehicle_brand, COUNT(*) AS brand_count FROM `table` GROUP BY Vehicle_brand";
$result_brand_counts = $connections->query($sql_brand_counts);

$brand_labels = array();
$brand_counts = array();



while ($row = $result_brand_counts->fetch_assoc()) {
    $brand_labels[] = $row['Vehicle_brand'];
    $brand_counts[] = $row['brand_count'];
}
$sql_reservation_day_count = "SELECT DAYNAME(Date) AS day, COUNT(*) AS reservations_per_day FROM `table` GROUP BY DAYNAME(Date)";
$result_reservation_day_count = $connections->query($sql_reservation_day_count);

$reservation_days = array();
$reservation_day_counts = array();

if ($result_reservation_day_count) {
    while ($row = $result_reservation_day_count->fetch_assoc()) {
        $reservation_days[] = $row['day'];
        $reservation_day_counts[] = $row['reservations_per_day'];
    }
}



$query = "SELECT * FROM `table` ORDER BY Status DESC, Date DESC, Time DESC"; 
$result = mysqli_query($connections, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="Cross-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="sidebarr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    
    <script src="logout.js"></script>
    <script src="actions_functions.js"></script>
    <script src="Dashboard-pie.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      
        const twoWheelCount = <?php echo $two_wheel_count; ?>;
        const fourWheelCount = <?php echo $four_wheel_count; ?>;
        const vehiclePieCtx = document.getElementById('vehiclePieChart').getContext('2d');
        const vehiclePieChart = new Chart(vehiclePieCtx, {
            type: 'pie',
            data: {
                labels: ['2 Wheel', '4 Wheel'],
                datasets: [{
                    label: 'Vehicle Types',
                    data: [twoWheelCount, fourWheelCount],
                    backgroundColor: ['#3888BC', '#013A6A'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                }
            }
        });

   
        const reservationDays = <?php echo json_encode($reservation_days); ?>;
        const reservationDayCounts = <?php echo json_encode($reservation_day_counts); ?>;
        const histogramCtx = document.getElementById('reservationHistogram').getContext('2d');
        const histogramChart = new Chart(histogramCtx, {
            type: 'line',
            data: {
                labels: reservationDays,
                datasets: [{
                    label: 'Reservations per Day',
                    data: reservationDayCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        
        const brandLabels = <?php echo json_encode($brand_labels); ?>;
        const brandCounts = <?php echo json_encode($brand_counts); ?>;
        const brandPieCtx = document.getElementById('brandPieChart').getContext('2d');
        const brandPieChart = new Chart(brandPieCtx, {
            type: 'pie',
            data: {
                labels: brandLabels,
                datasets: [{
                    label: 'Vehicle Brands',
                    data: brandCounts,
                    backgroundColor:
                     ['#79C9FF', '#FF8C98', 
                     '#FFC57E', '#FFFF94', 
                     '#A7FFA5', '#A8ADFF', 
                     '#C88BFF', '#FFAFFA', 
                     '#79C9FF'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                }
            }
        });

       
        const showNavbar = (toggleId, navId, bodyId, headerId) =>{
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);
        
        if(toggle && nav && bodypd && headerpd){
            toggle.addEventListener('click', ()=>{
                nav.classList.toggle('show');
                toggle.classList.toggle('bx-x');
                bodypd.classList.toggle('body-pd');
                headerpd.classList.toggle('body-pd');
            });

           
            const navLinks = nav.querySelectorAll('.nav_link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    nav.classList.remove('show');
                    toggle.classList.remove('bx-x');
                    bodypd.classList.remove('body-pd');
                    headerpd.classList.remove('body-pd');
                });
            });
        }
    };

    showNavbar('header-toggle','nav-bar','body-pd','header');
   
    const linkColor = document.querySelectorAll('.nav_link');
    function colorLink(){
        if(linkColor){
            linkColor.forEach(l=> l.classList.remove(''));
            this.classList.add('');
        }
    }
    linkColor.forEach(l=> l.addEventListener('click', colorLink));
});
</script>

</head>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
            <a href="mehk.html" class="nav_logo"> <i class="fas fa-layer-group nav_logo-icon"></i> <span class="nav_logo-name">Vehicle reservation </span> </a>
<div class="nav_list"> 
    <a href="dashboard" class="nav_link "> <i class="fas fa-th-large nav_icon"></i> <span class="nav_name">Dashboard</span> </a> 
    <a href="admin" class="nav_link"> <i class="fas fa-plus nav_icon"></i> <span class="nav_name">Add Vehicle</span> </a> 
    <a href="accounts" class="nav_link"> <i class="fas fa-user nav_icon"></i> <span class="nav_name">Accounts</span> </a> 

</div>

            </div> 
            <a href="#" class="nav_link" onclick="logout()"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">log out</span> </a>
        </nav>
    </div>


    <footer class="footer1">
        <div class="footer-section">
            <br>
            <a href="#" style="margin-right: 980px;"><b>● Vehicle reservation</a></b>
            <a href="#">● Terms and Conditions</a>
            <a href="#">● Privacy Policy</a>
        </div>
        <div class="footer-section">
            <br>
            <a href="#">● Contacts</a>
            <a href="#">● About Us</a>
        </div>
    </footer><br><br>
    
    <div class="container4">
    
        <b><h1>Dashboard</h1></b><br>
        <span class="span">
            <h3>Total vehicles</h3>
            <h1><?php echo isset($vehicle_count) ? $vehicle_count : 'N/A'; ?></h1>
            <i class="fas fa-bars" style="position: absolute; top: 10px; right: 15px; font-size: 25px;"></i>
        </span>
        <span class="z">
            <h3>Approved</h3>
            <h1><?php echo $approved_count; ?></h1>
            <i class="fas fa-check" style="position: absolute; top: 10px; right: 15px; font-size: 25px;"></i>
        </span><br>
        <span class="x">
            <h3>Rejected</h3>
            <h1><?php echo $rejected_count; ?></h1>
            <i class="fas fa-times" style="position: absolute; top: 10px; right: 15px; font-size: 25px;"></i>
        </span>
   
        <span class="s">
            <h3>Pending</h3>
            <h1><?php echo $pending_count; ?></h1>
            <i class="fas fa-spinner fa-spin" style="position: absolute; top: 10px; right: 15px; font-size: 25px;"></i>
        </span>

        <span class="admins">
            <h3>Admins</h3>
            <h1><?php echo $admin_count; ?></h1>
        </span>

        <span class="users">
            <h3>Users</h3>
            <h1><?php echo $user_count; ?></h1>
        </span>
    
        <span class="o">
            <canvas id="vehiclePieChart"></canvas>
            <canvas id="brandPieChart"></canvas>
        </span>
    
        <span class="reservation-histogram-container">
            <canvas id="reservationHistogram"></canvas>
        </span>

        <span class="recent">
    <h3>Recently Made Reservations</h3>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr class="tr1">
                    <th>Reservation id</th>
                    <th>Date</th>
                    <th>Time</th>
                    
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_reservations as $reservation) : ?>
                    <tr>
                        <td><?php echo $reservation['Reservation_id']; ?></td>
                        <td><?php echo $reservation['Date']; ?></td>
                        <td><?php echo $reservation['Time']; ?></td>
                       
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</span>

       

    </div>
    </div>
    </div>
    </div>
    </div>
</body>
</html>