<?php
include "includes/config.php";

    session_start();
    $sql="INSERT INTO customer 
                      (customer_name,customer_email,customer_pwd,customer_phone,customer_address,customer_role)
               VALUES ('{$_POST['name']}','{$_POST['email']}','{$_POST['pwd']}','{$_POST['phone']}','{$_POST['address']}','{$_POST['role']}');";
    $result = $conn->query($sql);
    $conn->close();
        echo "<script>
        alert('Book successfully added!');
        window.location.href = 'http://localhost/Thelannn%20Project/admin/index.php?succesfullyAdded';
    </script>";
    exit;
?>
