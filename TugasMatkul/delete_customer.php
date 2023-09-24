<?php
//Deskripsi: Menghapus data customer dan mengupdate ke database

require_once 'db_login.php';
//Mendapatkan customerid yang dilewatkan ke url
$id = $_GET['id']; 
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

//Update data into database
if ($op == 'delete') {
    //asign a query
    $query =
        " DELETE FROM customers WHERE customerid ='$id'";
    //execute the query
    $result = $db->query($query);
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
            <div class="card-header">Delete Page</div>
            <div class="card-body">
                <h3>Berhasil Hapus Data Customer</h3>
                <br><br>
                <a class="btn btn-primary" href="view_customer2.php">Kembali ke Data Customer</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
<?php $db->close();
?>
