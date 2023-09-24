<?php
//Deskripsi: Menghapus session

session_start();
if(isset($_SESSION['cart'])){
    //Fungsi unset() dapat digunakan untuk membatalkan setel variabel
    unset($_SESSION['cart']);
}
header('Location: view_books_detail.php');
?>