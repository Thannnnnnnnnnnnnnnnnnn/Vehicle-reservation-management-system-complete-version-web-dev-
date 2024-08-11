<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>delete</title>
</head>
<body>
    <?php
include("connections.php");


if(isset($_GET['id']) && !empty($_GET['id'])) {
   
    $Reservation_id = $_GET['id'];

   
    $sql = "DELETE FROM `2222` WHERE Reservation_id='$Reservation_id'";
    $result = mysqli_query($connections, $sql);

    if ($result) {
        
        header("Location: user.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($connections);
    }
} else {
    
    header("Location: user.php");
    exit();
}
?>

    
</body>
</html>