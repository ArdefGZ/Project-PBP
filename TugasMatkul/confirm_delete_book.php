<!DOCTYPE HTML> 
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Praktikum 4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style/confirm_delete_book_styles.css">
</head>

<body> 
	<div class="container">
	<br>
	<div class="card">
	<div class="card-header">Confirm Delete Book Data</div>
	<div class="card-body">
	<br>
	<?php
	$id = $_GET['id'];
	//include our login information
	require_once('db_login.php');
	$query = "SELECT * FROM books WHERE isbn = '" . $id . "'";
	$result = $db->query( $query );
	if (!$result){
		die ("Could not query the database: <br />". $db->error);
	} else{
		while ($row = $result->fetch_object()){
			echo '<table class="table">';
			echo '<tr><td>ISBN</td> <td>:</td> <td>'.$row->isbn.'</td></tr>';
			echo '<tr><td>Author</td> <td>:</td> <td>'.$row->author.'</td></tr>';
			echo '<tr><td>Category ID</td> <td>:</td> <td>'.$row->categoryid.'</td></tr>';
			echo '<tr><td>Title</td> <td>:</td> <td>'.$row->title.'</td></tr>';
			echo '<tr><td>Price</td> <td>:</td> <td>'.$row->price.'</td></tr>';
			echo '<table>';
			echo '';
			echo 'Are you sure want to delete this item?<br><a class="btn btn-danger" href="delete_book.php?id='.$id.'&op=delete">Yes</a>&nbsp;<a class="btn btn-primary" href="view_books_detail.php">No</a> &nbsp; &nbsp;';
		}
	}	
	?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	</div>
	</div>
	</div>
</body>
</html>
