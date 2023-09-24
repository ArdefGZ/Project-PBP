<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="style/table_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <main class="table">
        <section class="table__header">
            <h1>Book's Data</h1>
            <div class="input-group">
                <input type="search" id="search" placeholder="Search by Title...">
            </div>
            <a class="custom-button" href="add_book.php">+ Add Book Data</a><br /><br />
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <input type="checkbox" id="export-file">
                <div class="export__file-options">
                    <label>Export As &nbsp; &#10140;</label>
                    <label for="export-file" id="toPDF">PDF <img src="img/pdf.png" alt=""></label>
                    <label for="export-file" id="toJSON">JSON <img src="img/json.png" alt=""></label>
                    <label for="export-file" id="toCSV">CSV <img src="img/csv.png" alt=""></label>
                    <label for="export-file" id="toEXCEL">EXCEL <img src="img/excel.png" alt=""></label>
                </div>
            </div>
        </section>
        <section class="table__body">
            <div class="mb-3">
                <label for="categorySelect">Category:</label>
                <select class="form-select" id="categorySelect">
                    <option value="">All Categories</option>
                    <option value="Fiction">Fiction</option>
                    <option value="Science Fiction">Science Fiction</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Romance">Romance</option>
                    <option value="Fantasy">Fantasy</option>
                </select>
            </div>
            <table id="bookTable">
                <thead>
                    <tr>
                        <th> ISBN <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Author <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Category <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Title <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Price <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Action <span class="icon-arrow">&UpArrow;</span></th>
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
                    $query = "SELECT a.isbn, a.author, b.name, a.title, a.price FROM books a, categories b WHERE a.categoryid = b.categoryid AND title LIKE '%$search_query%'";
                    if (!empty($category_filter)) {
                        $query .= " AND name = '$category_filter'";
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
                        echo '<td>' . $row->name . '</td>';
                        echo '<td>' . $row->title . '</td>';
                        echo '<td> $' . $row->price . '</td>';
                        echo '<td><a class="btn btn-warning btn-sm" href="edit_book.php?id=' . $row->isbn . '">Edit</a>&nbsp;&nbsp;
                            <a class="btn btn-danger btn-sm" href="confirm_delete_book.php?id=' . $row->isbn . '&op=delete">Delete</a>
                            </td>';
                        echo '</tr>';
                    }
                    $result->free();
                    $db->close();
                    ?>
                    <br><br>
                </tbody>
            </table>
            <p id="totalRows"></p>
            <script>
           

            // JavaScript to filter and update the table based on the selected category
            document.getElementById('categorySelect').addEventListener('change', function() {
                filterTable();
            });

            // JavaScript to filter and update the table based on the title search input
            document.getElementById('search').addEventListener('input', function() {
                filterTableByTitle();
            });

            // Function to filter and update the table based on search and category filters
            function filterTable() {
                const searchValue = document.getElementById('search').value.toLowerCase();
                const categoryValue = document.getElementById('categorySelect').value;
                const rows = document.querySelectorAll("#bookTable tbody tr");
                let rowCount = 0; // Initialize row count

                rows.forEach(row => {
                    const title = row.querySelector("td:nth-child(4)").textContent.toLowerCase();
                    const category = row.querySelector("td:nth-child(3)").textContent;
                    if ((categoryValue === "" || category === categoryValue) && title.includes(searchValue)) {
                        row.style.display = "";
                        rowCount++; // Increment row count for visible rows
                    } else {
                        row.style.display = "none";
                    }
                });

                // Update the total rows count in the footer
                document.getElementById('totalRows').textContent = 'Total Rows = ' + rowCount;
            }

            // Function to filter and update the table based on the title search input
            function filterTableByTitle() {
                const titleSearchValue = document.getElementById('search').value.toLowerCase();
                const rows = document.querySelectorAll("#bookTable tbody tr");

                rows.forEach(row => {
                    const title = row.querySelector("td:nth-child(4)").textContent.toLowerCase();
                    if (title.includes(titleSearchValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
            
        </script>
        </section>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>
