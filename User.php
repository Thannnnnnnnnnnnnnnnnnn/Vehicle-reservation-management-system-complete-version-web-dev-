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

$query = "SELECT * FROM `table` ORDER BY Date DESC, Time DESC"; 
$result = mysqli_query($connections, $query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Vehicle_type = $_POST['Vehicle_type'];
    $Vehicle_color = $_POST['color'];
    $Vehicle_brand = ($_POST['Vehicle_brand'] == 'other') ? $_POST['Other_brand'] : $_POST['Vehicle_brand'];
    $Plate_no = $_POST['Plate_no'];
    $Date = $_POST['date']; 
    $Time = $_POST['Time']; 
    $Status = $_POST['Status']; 

    // Insert data into the `2222` table
    $sql_table = "INSERT INTO `table` (Vehicle_type, Vehicle_color, Vehicle_brand, Plate_no, Date, Time, Status) VALUES ('$Vehicle_type', '$Vehicle_color', '$Vehicle_brand','$Plate_no', '$Date','$Time', '$Status')";

    // Execute both queries and check for success
    if ($connections->query($sql_2222) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $connections->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add vehicle</title>
    <link rel="shortcut icon" href="Cross-Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="buttons.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="sidebarr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="logout.js"></script>
    <script src="editt-buttons.js"></script>
    <script src="view-button.js"></script>
    <script src="actions_functions.js"></script>
    <script src="admin.js"></script>
    

    

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
    <a href="add_vehicle" class="nav_link"> <i class="fas fa-plus nav_icon"></i> <span class="nav_name">Add vehicle</span> </a> 
    <a href="user" class="nav_link"> <i class="fas fa-table nav_icon"></i> <span class="nav_name">Table</span> </a> 


</div>

            </div> 
            <a href="#" class="nav_link" onclick="logout()"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">log out</span> </a>
        </nav>
    </div>

   
    
    <br><br>

    
        <div class="col">
            
                
                <div class="card-body">
                 
                    <br>
                    
             
                    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                    <table class="table">
                        <tr class="tr1">
                            <th>Reservation ID</th>
                            <th>Vehicle type</th>
                            <th>Vehicle color</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr><br><br>
                        
                        <?php while($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['Reservation_id']; ?></td>
                            <td><?php echo $row['Vehicle_type']; ?></td>
                            <td><?php echo $row['Vehicle_color']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td>
                              
                                   
                                <a href="#" class="view-button" data-bs-toggle="modal" data-bs-target="#viewModal" data-case-id="<?php echo $row['Reservation_id']; ?>">
                                    <i class='fas fa-eye'></i>
                                </a>    <b> |</b>
                                <a href="#" class="edit-button" data-bs-toggle="modal" data-bs-target="#editModal" data-case-id="<?php echo $row['Reservation_id']; ?>">
                                    <i class="fas fa-edit"></i>
                                </a>    <b> |</b>

                                
                                <form action="delete-history.php?id=<?php echo $row['Reservation_id']; ?>" method="POST" style="display: inline;">
                                    <button type="submit" class="delete-button" style="border: none; padding: 0;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                    <?php else : ?>
                    <p>No records found</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Full details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="caseDetails">
                  
                </div>
                
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="edit-case-form">
               
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>


  
   

<script>
    function addCurrentTimeToForm() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        const time = formattedHours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + ampm;
        
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'Time';
        hiddenInput.value = time;
        
       
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'Status';
        statusInput.value = 'Pending';

        document.querySelector('form').appendChild(hiddenInput);
        document.querySelector('form').appendChild(statusInput);
    }

    function toggleOtherBrandField() {
        const vehicleBrandSelect = document.getElementById('Vehicle_brand');
        const otherBrandField = document.getElementById('Other_brand_field');
        
        otherBrandField.style.display = (vehicleBrandSelect.value === 'other') ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('input[type="submit"]').addEventListener('click', addCurrentTimeToForm);
        document.getElementById('Vehicle_brand').addEventListener('change', toggleOtherBrandField);
        toggleOtherBrandField(); 
    });
</script>





</body>
</html>
