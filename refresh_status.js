function refreshData() {
        window.location.href = 'admin.php';
    }

 
    function filterRecords(status) {
        const url = `admin.php?status=${status}`;
        window.location.href = url;
    }
  