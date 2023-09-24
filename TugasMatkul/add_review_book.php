<!DOCTYPE HTML> 
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>
    <link rel="stylesheet" href="style/add_review_book_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body> 
    <div class="container">
        <br>
        <div class="card">
            <div class="card-header">Add Review</div>
            <div class="card-body">
                <br>
                <?php
                // Include login information
                require_once('db_login.php');
                
                // Cek apakah form telah disubmit
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id = $_POST['id'];
                    $review = $_POST['review'];
                    
                    // Simpan review ke basis data
                    $query = "INSERT INTO book_reviews (isbn, review) VALUES ('$id', '$review')";
                    $result = $db->query($query);
                    
                    if (!$result) {
                        die("Could not query the database: <br />". $db->error);
                    } else {
                        $db->close(); // Tutup koneksi
                        header('Location: success_add_book.php');
                    }
                }
                ?>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="mb-3">
                        <label for="review" class="form-label">Review</label>
                        <textarea class="form-control" id="review" name="review" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                    <a class="btn btn-secondary" href="view_books_detail.php">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
