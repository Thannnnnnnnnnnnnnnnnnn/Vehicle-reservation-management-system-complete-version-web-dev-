<?php
include("connections.php");

$query = "SELECT * FROM `accounts`"; 
$result = mysqli_query($connections, $query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tbl_id = $_POST['tbl_id'];
    $Email = $_POST['Email'];
    $password = $_POST['password'];
    $account_type = $_POST['account_type'];
    $Contact_No = $_POST['Contact_No']; 
    $Firstname = $_POST['Firstname']; 
    $Lastname = $_POST['Lastname']; 

    $sql = "INSERT INTO `accounts` (tbl_id, Email, password, account_type, Contact_No, Firstname, Lastname) VALUES ('$tbl_id', '$Email', '$password', '$account_type', '$Contact_No', '$Firstname', '$Lastname')";

    if ($connections->query($sql) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connections->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link rel="shortcut icon" href="Cross-Logo.png" type="image/x-icon">
    <script src="edit-buttons-accounts.js"></script>
    <script src="actions_functions.js"></script>
    <script src="logout.js"></script>
    <link rel="stylesheet" href="Main.css">
    <link rel="stylesheet" href="buttons.css">
    <link rel="stylesheet" href="sidebarr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
</head>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="mehk.html" class="nav_logo"> <i class="fas fa-layer-group nav_logo-icon"></i> <span class="nav_logo-name">Vehicle Reservation</span> </a>
                <div class="nav_list"> 
                    <a href="dashboard" class="nav_link"> <i class="fas fa-th-large nav_icon"></i> <span class="nav_name">Dashboard</span> </a> 
                    <a href="admin" class="nav_link"> <i class="fas fa-plus nav_icon"></i> <span class="nav_name">Add Vehicle</span> </a> 
                    <a href="accounts" class="nav_link"> <i class="fas fa-user nav_icon"></i> <span class="nav_name">Accounts</span> </a> 
                </div>
            </div> 
            <a href="#" class="nav_link" onclick="logout()"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">log out</span> </a>
        </nav>
    </div>
    <br><br><br><br>
    
    <div class="col">

    <b><h1>Accounts</h1></b><br>
    <table class="table">
        <thead>
            <tr class="tr1">
                <th>Account ID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Account Type</th>
                <th>Contact No.</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['tbl_id']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><?php echo $row['account_type']; ?></td>
                        <td><?php echo $row['Contact_No']; ?></td>
                        <td><?php echo $row['Firstname']; ?></td>
                        <td><?php echo $row['Lastname']; ?></td>
                        <td>
                            <a href="#" class="edit-button" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo $row['tbl_id']; ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                            <b> |</b>
                            <form action="delete-accounts.php?id=<?php echo $row['tbl_id']; ?>" method="POST" style="display: inline;">
                                <button type="submit" class="delete-button" style="border: none; padding: 0;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="edit-form">
                    <!-- Content loaded dynamically via JavaScript -->
                </div>
            </div>
        </div>
    </div>
    <script>
        
        $(document).ready(function() {
            $('.edit-button').click(function() {
                var id = $(this).data('id');
                $.get('edit-accounts-form.php', { id: id }, function(data) {
                    $('#edit-form').html(data);
                });
            });

            $(document).on('submit', '#edit-form', function(event) {
                event.preventDefault(); 
                var formData = $(this).serialize(); 
                $.ajax({
                    url: 'update-accounts.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#editModal').modal('hide');
                            location.reload(); 
                        } else {
                            alert('Failed to update record.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
                
            });
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

    </script>
</body>
</html>
