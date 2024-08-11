document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-button');

    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const reservationId = button.closest('form').getAttribute('action').split('=')[1];
            
            
            fetch('edit.php?id=' + reservationId)
                .then(response => response.text())
                .then(data => {
                    
                    Swal.fire({
                        html: data,
                        showCloseButton: true,
                        customClass: {
                            popup: 'bigger-swal-modal', 
                        },
                        width: '70%', 
                        heightAuto: false, 
                        height: '90%', 
                        showCancelButton: false, 
                        showConfirmButton: false 
                    }).then(() => {
                       
                        const updateButton = document.getElementById('updateButton');
                        updateButton.addEventListener('click', function() {
                           
                            Swal.fire({
                                
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // If confirmed, submit the form
                                    document.getElementById('updateForm').submit();
                                }
                            });
                        });
                    });

             
                   
                    const updateForm = document.getElementById('updateForm');
                    updateForm.addEventListener('change', function(event) {
                      
                      
                   
                    });
                })
                .catch(error => {
                    console.error('Error fetching edit form:', error);
                });
        });
    });
});
