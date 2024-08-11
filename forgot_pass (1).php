<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="2222.css">
    <link rel="shortcut icon" href="Cross-Logo.png" type="image/x-icon">
</head>
<body>
    <div class="container form-container">
        <h2>Forgot Password</h2>
        <?php
        // Initialize variables
        $email = "";
        $emailErr = "";

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate email
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
            } else {
                $email = test_input($_POST["email"]);
                // Check if email is valid
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
                // If email is valid, you can process the reset password functionality here
                // This is just a placeholder
                else {
                    // Perform operations for resetting password, e.g., sending reset link to the email
                    // Redirect or display a success message
                    echo "<p class='success-message'>Password reset instructions sent to your email.</p>";
                }
            }
        }

        // Function to sanitize form inputs
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <input type="submit" class="back-to-home-button" value="Reset Password">
        </form>
        <br>
        <div class="additional-options">
            <p>Remember your password? <a href="login.php">Login</a></p>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>

    <br>
    <footer>
        <p><a href="terms.php">Terms and Conditions</a></p>
        <p><a href="privacy.php">Privacy Policy</a></p>
        <p><a href="about.php">About Us</a></p>
        <p><a href="contacts.php">Contact Us</a></p>
    </footer>
    
</body>
</html>
