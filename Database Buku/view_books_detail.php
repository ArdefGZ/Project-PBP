<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="card mt-4">
        <div class="card-header">Books Data</div>
        <div class="card-body">
            <br>
            <a class="btn btn-primary" href="add_book.php">+ Add Book Data</a><br /><br />
            <!-- Filter section with search input and category selection -->
            <div class="mb-3">
                <input type="text" class="form-control" id="search" placeholder="Search...">
            </div>
            <div class="mb-3">
                <label for="categorySelect">Category:</label>
                <select class="form-select" id="categorySelect">
                    <option value="">All Categories</option>
                    <option value="1">Fiction</option>
                    <option value="2">Science Fiction</option>
                    <option value="3">Mystery</option>
                    <option value="4">Romance</option>
                    <option value="5">Fantasy</option>
                </select>
            </div>
            <!-- Table for displaying book data -->
            <table class="table table-striped" id="bookTable">
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include our login information
                    require_once('db_login.php');

                    // Initialize search query and category filter
                    $search_query = "";
                    $category_filter = "";

                    // Check if the search input and category filter are provided
                    if (isset($_GET['search'])) {
                        $search_query = $_GET['search'];
                    }
                    if (isset($_GET['category'])) {
                        $category_filter = $_GET['category'];
                    }

                    // Build the SQL query with search and category filter
                    $query = "SELECT isbn, author, categoryid, title, price FROM books WHERE title LIKE '%$search_query%'";
                    if (!empty($category_filter)) {
                        $query .= " AND categoryid = '$category_filter'";
                    }
                    $query .= " ORDER BY isbn";

                    $result = $db->query($query);

                    if (!$result) {
                        die("Could not query the database: <br />" . $db->error . "<br>Query: " . $query);
                    }

                    // Fetch and display the results
                    while ($row = $result->fetch_object()) {
                        echo '<tr>';
                        echo '<td>' . $row->isbn . '</td>';
                        echo '<td>' . $row->author . '</td>';
                        echo '<td>' . $row->categoryid . '</td>';
                        echo '<td>' . $row->title . '</td>';
                        echo '<td> $' . $row->price . '</td>';
                        echo '<td><a class="btn btn-warning btn-sm" href="edit_book.php?id=' . $row->isbn . '">Edit</a>&nbsp;&nbsp;
                            <a class="btn btn-danger btn-sm" href="delete_book.php?id=' . $row->isbn . '&op=delete">Delete</a>
                            </td>';
                        echo '</tr>';
                    }
                    $result->free();
                    $db->close();
                    ?>
                </tbody>
            </table>
            <br />
            <script>
                // JavaScript to filter and update the table when input changes
                document.getElementById('search').addEventListener('input', function () {
                    filterTable();
                });

                // JavaScript to filter and update the table based on the selected category
                document.getElementById('categorySelect').addEventListener('change', function () {
                    filterTable();
                });

                // Function to filter and update the table based on search and category filters
                function filterTable() {
                    const searchValue = document.getElementById('search').value.toLowerCase();
                    const categoryValue = document.getElementById('categorySelect').value;
                    const rows = document.querySelectorAll("#bookTable tbody tr");

                    rows.forEach(row => {
                        const title = row.querySelector("td:nth-child(4)").textContent.toLowerCase();
                        const category = row.querySelector("td:nth-child(3)").textContent;
                        if ((categoryValue === "" || category === categoryValue) && title.includes(searchValue)) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    });
                }
            </script>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
