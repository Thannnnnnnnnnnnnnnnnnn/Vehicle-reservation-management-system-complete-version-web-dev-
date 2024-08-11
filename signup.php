<?php

include 'connections.php';

$email = $password = $contact_no = $firstname = $lastname = $register = "";
$email_err = $password_err = $contact_no_err = $firstname_err = $lastname_err = "";
$alert_script = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
        $sql_check_email = "SELECT Email FROM accounts WHERE Email = ?";
        $stmt = $connections->prepare($sql_check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $email_err = "Email is already registered.";
            $alert_script = "<script>document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Email is already registered.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });</script>";
        }
        $stmt->close();
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate and format contact number
    if (empty(trim($_POST["Contact_No"]))) {
        $contact_no_err = "Please enter your contact number.";
    } elseif (!preg_match('/^09\d{9}$/', trim($_POST["Contact_No"]))) {
        $contact_no_err = "Invalid contact number format. It should be 11 digits and start with 09.";
    } else {
        $contact_no = trim($_POST["Contact_No"]);
        // Convert to E.164 format
        $contact_no = '+63' . substr($contact_no, 1);
    }

    // Validate first name
    if (empty(trim($_POST["Firstname"]))) {
        $firstname_err = "Please enter your firstname.";
    } else {
        $firstname = trim($_POST["Firstname"]);
    }

    // Validate last name
    if (empty(trim($_POST["Lastname"]))) {
        $lastname_err = "Please enter your lastname.";
    } else {
        $lastname = trim($_POST["Lastname"]);
    }

    // Determine account type
    $account_type = ($password === 'admin') ? 1 : 2;

    // Insert the data into the database if no errors
    if (empty($email_err) && empty($password_err) && empty($contact_no_err) && empty($firstname_err) && empty($lastname_err)) {

        require 'PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'VehicleReservationManagement@gmail.com';
        $mail->Password = 'fzja ezgo ojdu fobc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('VehicleReservationManagement@gmail.com', 'Vehicle Reservation Management');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Default password';
        $mail->Body = "This is your password: <font color='red'><b>$password</b></font>";

        if (!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        } else {
            // Insert into the database
            $sql = "INSERT INTO accounts (Email, Password, Contact_No, Firstname, Lastname, account_type) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = $connections->prepare($sql)) {
                $stmt->bind_param("sssssi", $email, $password, $contact_no, $firstname, $lastname, $account_type);
                if ($stmt->execute()) {
                    // Send SMS notification
                   

                    $alert_script = "<script>document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Successfully created an account',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'signup.php';
                        });
                    });</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $connections->error;
                }
                $stmt->close();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="buttons.css">
    <link rel="shortcut icon" href="Cross-Logo.png" type="image/x-icon">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-image: linear-gradient(to right, darkblue, skyblue, cyan, white);">
<div class="wave"></div>
<div class="wave"></div>
<div class="wave"></div>
<div class="container2 form-container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Sign Up</h1>
        <span><?php echo $register; ?></span>
        <span><?php echo $email_err; ?></span>
        <span><?php echo $password_err; ?></span>
        <span><?php echo $contact_no_err; ?></span>
        <span><?php echo $firstname_err; ?></span>
        <span><?php echo $lastname_err; ?></span>
        
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">

        <label for="password">Password</label>
        <input type="text" name="password" id="password">

        <label for="Contact_No">Contact No.</label>
        <input type="text" name="Contact_No" id="Contact_No" value="<?php echo htmlspecialchars($contact_no); ?>">

        <label for="Firstname">Firstname</label>
        <input type="text" name="Firstname" id="Firstname" value="<?php echo htmlspecialchars($firstname); ?>">

        <label for="Lastname">Lastname</label>
        <input type="text" name="Lastname" id="Lastname" value="<?php echo htmlspecialchars($lastname); ?>">

        <input type="submit" class="back-to-home-button" value="Sign up">
      
        <div class="additional-options">
            <center>
                <br>
                <a href="login" class="add2-button">Back to login</a>
            </center>
        </div>
    </form>
</div>
<footer>
    <p>Vehicle reservation.</p>
    <p>©BSIT - 2222 - Than</p>
</footer>
<?php
// Output the alert script if set
echo $alert_script;
?>
</body>
</html>
