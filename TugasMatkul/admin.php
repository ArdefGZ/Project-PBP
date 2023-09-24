<?php
//Deskripsi: Halaman dapat ditampilkan saat user telah login, ketika belum maka di-redirect ke halaman login.php
session_start(); //inisialisasi session
if (!isset($_SESSION['username'])){
    header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tugas PBP - Koneksi ke Basis Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>
<br>
    <div class="container">
        <div class="card">
            <div class="card-header">Admin Page</div>
            <div class="card-body">
                <p>Welcome ...</p>
                <p>You are logged in as <b><?php echo $_SESSION['username']; ?></p>
                <br><br>
                <a class="btn btn-primary" href="logout.php">Logout</a>
                <a class="btn btn-primary" href="view_customer2.php">View Customer</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
