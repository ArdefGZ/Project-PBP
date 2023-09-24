<!DOCTYPE HTML> 
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Praktikum 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body> 
    <div class="container">
        <br>
        <div class="card">
            <div class="card-header">Book Review</div>
            <div class="card-body">
                <br>
                <?php
                $id = $_GET['id'];
                //include our login information
                require_once('db_login.php');
                $query = "SELECT a.isbn, a.author, b.name, a.title, a.price, c.review FROM books a, categories b, book_reviews c WHERE a.categoryid = b.categoryid AND a.isbn = c.isbn AND a.isbn = '" . $id . "'";
                $result = $db->query($query);
				$query2 = "SELECT a.isbn, a.author, b.name, a.title, a.price FROM books a, categories b WHERE a.categoryid = b.categoryid AND a.isbn = '" . $id . "'";
                $result2 = $db->query($query2);
				if (!$result || !$result2){
                    die ("Could not query the database: <br />". $db->error);
                } else{
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_object()){
                            echo '<table class="table">';
                            echo '<tr><td>ISBN</td> <td>:</td> <td>'.$row->isbn.'</td></tr>';
                            echo '<tr><td>Author</td> <td>:</td> <td>'.$row->author.'</td></tr>';
                            echo '<tr><td>Category ID</td> <td>:</td> <td>'.$row->name.'</td></tr>'; // Assuming category name is in 'name' column
                            echo '<tr><td>Title</td> <td>:</td> <td>'.$row->title.'</td></tr>';
                            echo '<tr><td>Price</td> <td>:</td> <td>'.$row->price.'</td></tr>';
                            echo '<tr><td>Review</td> <td>:</td> <td>'.$row->review.'</td></tr>';
                            echo '</table>';
                        }
					} else {
						while ($row = $result2->fetch_object()){
							echo '<table class="table">';
							echo '<tr><td>ISBN</td> <td>:</td> <td>'.$row->isbn.'</td></tr>';
							echo '<tr><td>Author</td> <td>:</td> <td>'.$row->author.'</td></tr>';
							echo '<tr><td>Category ID</td> <td>:</td> <td>'.$row->name.'</td></tr>'; // Assuming category name is in 'name' column
							echo '<tr><td>Title</td> <td>:</td> <td>'.$row->title.'</td></tr>';
							echo '<tr><td>Price</td> <td>:</td> <td>'.$row->price.'</td></tr>';
							echo '</table>';
						}   
						echo '<div class="d-flex justify-content-between align-items-center">';
						echo 'No reviews available for this book.';
						echo '<a href="add_review_book.php?id='.$id.'" class="btn btn-primary">Add Review</a>';
						echo '</div>';
					}
									
                }   
                ?>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
            </div>
        </div>
    </div>
</body>
</html>
