<?php
//Deskripsi: Menampilkan form edit data customer dan mengupdate ke database

require_once('db_login.php');
//Mendapatkan customerid yang dilewatkan ke url
$id = $_GET['id']; 

//mengecek apakah user belum mengklik tombol submit
if (!isset($_POST["submit"])){
    $query = " SELECT * FROM books WHERE isbn=" .$id. " ";
    //execute the query
    $result = $db->query($query);
    if (!$result){
        die ("Could not the query database: <br />" . $db->error);
    } else {
        while ($row = $result->fetch_object()){
            $author = $row->author;
            $categoryid = $row->categoryid;
            $title = $row->title;
            $price = $row->price;
        }
    }
} else{

    $valid = TRUE; //flag validasi
    $author = test_input($_POST['author']);
    if ($author == ''){
        $error_author = "Author is required";
        $valid = FALSE;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $author)){
        $error_author = "Only letters and white space allowed";
        $valid = FALSE;
    }

    $categoryid = $_POST['categoryid'];
    if ($categoryid == '' || $categoryid == 'none'){
        $error_categoryid = "Category is required";
        $valid = FALSE;
    }

    $title = test_input($_POST['title']);
    if ($title == ''){
        $error_title = "Title is required";
        $valid = FALSE;
    }

    $price = test_input($_POST['price']);
    if ($price == ''){
        $error_price = "Price is required";
        $valid = FALSE;
    }


    //add data into database
    if ($valid){
        //escape inputs data
        $title = $db->real_escape_string($title); //menghapus tanda petik
        //asign a query
        $query = "UPDATE books SET author='".$author."', categoryid='".$categoryid."', title='".$title."', price='".$price."' WHERE isbn=".$id;
        //execute the query
        $result = $db->query($query);
        if (!$result){
            die ("Could not the query the database: <br />" . $db->error . '<br>Query:' .$query);
        } else{
            //Saat di submit, maka pindah ke halaman view_customer.php
            $db->close();
            header('Location: view_books_detail.php');
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">Edit Book Data</div>
            <div class="card-body">
                <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id=' .$id; ?>">
                    <div class="form-group">
                        <label for="author">Author:</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>">
                        <div class="text-danger"><?php if (isset($error_author)) echo $error_author;?></div>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="categoryid" id="category" class="form-control" required>
                            <!-- Pilihan kategori -->
                            <option value="none" <?php if ($categoryid == 'none') echo 'selected="true"'; ?>>--Select a category--</option>
                            <option value="1" <?php if ($categoryid == '1') echo 'selected="true"'; ?>>Fiction</option>
                            <option value="2" <?php if ($categoryid == '2') echo 'selected="true"'; ?>>Science Fiction</option>
                            <option value="3" <?php if ($categoryid == '3') echo 'selected="true"'; ?>>Mystery</option>
                            <option value="4" <?php if ($categoryid == '4') echo 'selected="true"'; ?>>Romance</option>
                            <option value="5" <?php if ($categoryid == '5') echo 'selected="true"'; ?>>Fantasy</option>
                        </select>
                        <div class="text-danger"><?php if(isset($error_categoryid)) echo $error_categoryid;?></div>
                    </div>
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
                        <div class="text-danger"><?php if (isset($error_title)) echo $error_title;?></div>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
                        <div class="text-danger"><?php if (isset($error_price)) echo $error_price;?></div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
                    <a href="view_books_detail.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
<?php
$db->close();
?>