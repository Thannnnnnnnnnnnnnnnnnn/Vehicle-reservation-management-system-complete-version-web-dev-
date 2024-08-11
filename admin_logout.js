


function confirmLogout() {
    
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will be logged out',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, log out!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        
        if (result.isConfirmed) {
            
            window.location.href = 'logout.php'; 
        }
    });
    
    return false;
}
