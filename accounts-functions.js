

    $(document).on('submit', '#edit-case-form', function(event) {
        event.preventDefault(); 
        var formData = $(this).serialize(); 
        $.ajax({
            url: 'edit_case.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    
                   
                    $('#editModal').modal('hide');
                   
                    location.reload(); 
                } else {
                   
                   
                    alert('Failed to update reservation.');
                }
            },
            error: function(xhr, status, error) {
              
                console.error(xhr.responseText);
            }
        });
    });

document.addEventListener("DOMContentLoaded", function(event) {
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