<?php
session_start();

// Cek apakah user punya hak untuk mengakses halaman ini
if (!isset($_SESSION['order_auth']) || !isset($_SESSION['id'])) {
    header("location:login.php?Unauthorized");
    die();
}

require('./includes/config.php');

$today_date = date("Y/n/j/");

if (!isset($_GET['items'])) {
    // Pemesanan satu item
    $sql = "INSERT INTO rentorders (
        cid,
        bid,
        price,
        date,
        return_date
    ) VALUES (
        {$_SESSION['id']},
        {$_GET['id']},
        {$_SESSION['payment_amt']},
        '{$today_date}',
        '{$_SESSION['return_date']}'
    )";

    $conn->query($sql);

    unset($_SESSION['payment_amt'], $_SESSION['return_date']);
} else {
    // Pemesanan dari keranjang (banyak item)
    $sql = "SELECT * FROM carts WHERE uid = {$_SESSION['id']} AND status = 'active'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $sql2 = "INSERT INTO rentorders (
            cid,
            bid,
            quantity,
            price,
            date,
            return_date
        ) VALUES (
            {$_SESSION['id']},
            {$row['pid']},
            {$row['quantity']},
            {$row['price']},
            '{$today_date}',
            '{$row['return_date']}'
        )";
        $conn->query($sql2);
    }

    // Hapus isi keranjang setelah transaksi
    $sql3 = "DELETE FROM carts WHERE uid = {$_SESSION['id']}";
    $conn->query($sql3);
}

$conn->close();
unset($_SESSION['order_auth']);
?>

<!-- Tampilan pesan sukses -->
<style>
    .mess-cont {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .mess-box {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 70%;
        width: 60%;
        box-shadow: 10px 10px 34px 7px rgba(204, 247, 203, 0.75);
    }

    .mess {
        height: clamp(250px, 540px, 70%);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>
<link rel="stylesheet" href="./css/style.php">
<div class="mess-cont">
    <div class="mess-box">
        <div class="mess">
            <img src="./images/Thanks.jpeg" alt="Thank You" style="height:80%;width:100%">
            <h3 style="color:grey">Your order is on the way!</h3>
            <h3 style="color:grey;text-align:center">Thanks for Choosing our Rent Store ^_^</h3>
            <button class="btn" style="background:#11C9B6;border:none;">
                <a href="./products.php?type=new" style="color:white;text-decoration:none;">Continue Renting to our Store</a>
            </button>
        </div>
    </div>
</div>