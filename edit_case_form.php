<?php
include("connections.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    
    $caseId = $_POST['edit-case-id'];
    $vehicleType = $_POST['edit-case-vehicle-type'];
    $vehicleColor = $_POST['edit-case-vehicle-color'];
    $vehicleBrand = $_POST['edit-case-vehicle-brand'];
    $vehiclePlate = $_POST['edit-case-vehicle-plate'];
    
    $target_file = ''; // Initialize the target file
    
    // Check if a new image file is uploaded
    if (!empty($_FILES['edit-case-new-plate-image']['tmp_name'])) {
        $target_dir = "C:\\xampp\\htdocs\\adi\\image\\";
        $target_file = $target_dir . basename($_FILES['edit-case-new-plate-image']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['edit-case-new-plate-image']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES['edit-case-new-plate-image']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (!move_uploaded_file($_FILES['edit-case-new-plate-image']['tmp_name'], $target_file)) {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update the database with the new information, including the image file name
    $query = "UPDATE `table` SET Vehicle_type=?, Vehicle_color=?, Vehicle_brand=?, Plate_no=?, Plate_image=? WHERE Reservation_id=?";
    
    $stmt = mysqli_prepare($connections, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $vehicleType, $vehicleColor, $vehicleBrand, $vehiclePlate, basename($target_file), $caseId);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        echo "Changes saved successfully.";
    } else {
        echo "Error: " . mysqli_error($connections);
    }

    mysqli_stmt_close($stmt);
} else {
    // Display the form for editing
    
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
               
                $html = "<form id='edit-case-form' method='post' enctype='multipart/form-data'>";
                $html .= "<input type='hidden' name='edit-case-id' value='{$row['Reservation_id']}'>";
                $html .= "<div class='mb-3'>";
                $html .= "<label for='edit-case-vehicle-type' class='form-label'>Vehicle Type</label>";
                $html .= "<input type='text' class='form-control' id='edit-case-vehicle-type' name='edit-case-vehicle-type' value='{$row['Vehicle_type']}'>";
                $html .= "</div>";
                $html .= "<div class='mb-3'>";
                $html .= "<label for='edit-case-vehicle-color' class='form-label'>Vehicle Color</label>";
                $html .= "<input type='text' class='form-control' id='edit-case-vehicle-color' name='edit-case-vehicle-color' value='{$row['Vehicle_color']}'>";
                $html .= "</div>";
                $html .= "<div class='mb-3'>";
                $html .= "<label for='edit-case-vehicle-brand' class='form-label'>Vehicle Brand</label>";
                $html .= "<input type='text' class='form-control' id='edit-case-vehicle-brand' name='edit-case-vehicle-brand' value='{$row['Vehicle_brand']}'>";
                $html .= "</div>";
                $html .= "<div class='mb-3'>";
                $html .= "<label for='edit-case-vehicle-plate' class='form-label'>Vehicle Plate Number</label>";
                $html .= "<input type='text' class='form-control' id='edit-case-vehicle-plate' name='edit-case-vehicle-plate' value='{$row['Plate_no']}'>";
                $html .= "</div>";
                
                // Display the file input field for uploading a new image
                $html .= "<div class='mb-3'>";
                $html .= "<label for='edit-case-new-plate-image' class='form-label'>New Plate Image</label><br>";
                $html .= "<input type='file' class='form-control' id='edit-case-new-plate-image' name='edit-case-new-plate-image' accept='image/*'>";
                $html .= "</div>";
                
                $html .= "<button type='submit' class='add-button'>Save Changes</button>";
                $html .= "<button type='button' class='close-button' data-bs-dismiss='modal'>Close</button>";
                
                $html .= "</form>";
                
                echo $html;
            } else {
                echo "No case found with the provided ID.";
            }
        } else {
            echo "Query execution failed.";
        }
    } else {
        echo "No case ID provided.";
    }
}

mysqli_close($connections);
?>
<link rel="stylesheet" href="buttons.css">
