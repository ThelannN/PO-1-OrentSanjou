<?php
    include "includes/config.php";
$sql = "DELETE FROM customer where customer_id={$_GET['id']}"; //sql query for deleting
$conn->query($sql); //executing sql query

    echo "<script>
        alert('Book successfully removed!');
        window.location.href = 'http://localhost/Thelannn%20Project/admin/index.php?succesfullyRemoved';
    </script>";
    exit;
?>