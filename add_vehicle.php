<?php
session_start(); // Start the session

include("connections.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Vehicle_type = $_POST['Vehicle_type'];
    $Vehicle_color = $_POST['color'];
    $Vehicle_brand = ($_POST['Vehicle_brand'] == 'other') ? $_POST['Other_brand'] : $_POST['Vehicle_brand'];
    $Plate_no = $_POST['Plate_no'];
    $Date = $_POST['date'];
    $Time = $_POST['Time'];
    $Status = 'Pending'; // Set the status directly
    $Plate_image = $_FILES['Plate_image'];
    $target_file = "";

    // Check if a file is uploaded
    if (!empty($Plate_image["tmp_name"])) {
        $target_dir = "C:\\xampp\\htdocs\\adi\\image\\";
        $target_file = $target_dir . basename($Plate_image["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file already exists in the destination directory
        if (file_exists($target_file)) {
            echo "<script>showAlert('error', 'Error', 'This file already exists. Please choose a different one.');</script>";
            $uploadOk = 0;
        }

        $check = getimagesize($Plate_image["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>showAlert('error', 'Error', 'File is not an image.');</script>";
            $uploadOk = 0;
        }

        if ($Plate_image["size"] > 2000000) {
            echo "<script>showAlert('error', 'Error', 'Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "<script>showAlert('error', 'Error', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "<script>showAlert('error', 'Error', 'Sorry, your file was not uploaded.');</script>";
        } else {
            if (!move_uploaded_file($Plate_image["tmp_name"], $target_file)) {
                echo "<script>showAlert('error', 'Error', 'Sorry, there was an error uploading your file.');</script>";
            }
        }
    }

    // Prepare and bind the SQL statement
    $sql_table = "INSERT INTO `table` (Vehicle_type, Vehicle_color, Vehicle_brand, Plate_no, Date, Time, Status, Plate_image) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connections->prepare($sql_table);
    $stmt->bind_param("ssssssss", $Vehicle_type, $Vehicle_color, $Vehicle_brand, $Plate_no, $Date, $Time, $Status, $target_file);

    if ($stmt->execute()) {
        // Show SweetAlert2 dialog after successful form submission
        echo "<script>showSuccessAlert();</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
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
                <a href="add_vehicle" class="nav_link "> <i class="fas fa-plus nav_icon"></i> <span class="nav_name">Add Vehicle</span> </a>
                <a href="user" class="nav_link "> <i class="fas fa-table nav_icon"></i> <span class="nav_name">Table</span> </a>
            </div>
        </div>
        <a href="#" class="nav_link" onclick="logout()"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">log out</span> </a>
    </nav>
</div>
<div class="container3 form-container">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group select-container">
            <label for="Vehicle_type">Type of Vehicle</label>
            <select id="Vehicle_type" name="Vehicle_type">
                <option value="N/A">Choose</option>
                <option value="2 Wheel">2 Wheel</option>
                <option value="4 Wheel">4 Wheel</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="Vehicle_color">Vehicle Color</label>
            <input type="text" id="kulay" name="color" required placeholder="Enter vehicle color">
        </div>
        
        <div class="form-group select-container">
            <label for="Vehicle_brand">Vehicle Brand</label>
            <select id="Vehicle_brand" name="Vehicle_brand">
                <option value="N/A">Choose</option>
                <option value="toyota">Toyota</option>
                <option value="nissan">Nissan</option>
                <option value="suzuki">Suzuki</option>
                <option value="honda">Honda</option>
                <option value="hyundai">Hyundai</option>
                <option value="ford">Ford</option>
                <option value="kia">Kia</option>
                <option value="isuzu">Isuzu</option>
                <option value="lexus">Lexus</option>
                <option value="bmw">BMW</option>
                <option value="hilux">Hilux</option>
                <option value="subaru">Subaru</option>
                <option value="other">Other</option>
            </select>
        </div>
        
        <div class="form-group" id="Other_brand_field" style="display: none;">
            <label for="Other_brand">Other Brand</label>
            <input type="text" id="Other_brand" name="Other_brand" placeholder="Enter other brand">
        </div>

        <div class="form-group">
            <label for="Plate_no">Vehicle Plate Number</label>
            <input type="text" id="Plate_no" name="Plate_no" placeholder="Enter vehicle plate number">
        </div>
        
        <div class="form-group">
    <label for="Plate_image">Upload Plate Image (Optional)</label>
    <div style="display: flex; align-items: center;">
        <input type="file" id="Plate_image" name="Plate_image"  accept="image/*" onchange="previewImage(event)">
        <img id="preview" src="#" alt="Preview Image" style="display: none; max-width: 250px; margin-left: 10px;">
    </div>
</div>


        
        <div class="form-group">
            <label for="Date">Date</label>
            <input type="date" id="Date" name="date" required>
        </div>
        
        <input type="hidden" name="Status" value="pending"> <!-- Hidden input for status -->
        
        <input type="submit" class="back-to-home-button2" value="Submit">
    </form>
</div>
<script>
  function showSuccessAlert() {
            Swal.fire({
                icon: 'success',
                title: 'Reservation successful',
                text: 'Your vehicle reservation has been successfully submitted!',
                confirmButtonText: 'OK'
            });
        }

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

        function previewImage(event) {
            const fileInput = event.target;
            const preview = document.getElementById('preview');

            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }

</script>
</body>
</html>
