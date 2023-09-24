<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas PBP - Koneksi ke Basis Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Koneksi ke database Anda
            require_once("db_login.php");

            // Query untuk mengambil data dari tabel books dan categories
            $query = "SELECT books.isbn, books.title, books.author, books.price, categories.name as category_name 
                      FROM books
                      LEFT JOIN categories ON books.categoryid = categories.categoryid 
                      ORDER BY categories.categoryid, books.isbn;";

            // Eksekusi query
            $result = $db->query($query);

            if ($result->num_rows > 0) {
                $current_category = "";
                while ($row = $result->fetch_assoc()) {
                    if ($current_category != $row['category_name']) {
                        $current_category = $row['category_name'];
                        echo '<tr>';
                        echo "<td rowspan='" . getCategoryRowCount($db, $current_category) . "'>$current_category</td>";
                        echo "<td>" . $row['isbn'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['author'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo '</tr>';
                    } else {
                        echo '<tr>';
                        echo "<td>" . $row['isbn'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['author'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo '</tr>';
                    }
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data tersedia</td></tr>";
            }
            

            // Tutup koneksi
            $db->close();

            function getCategoryRowCount($db, $category) {
                $query = "SELECT COUNT(*) as row_count FROM books
                          LEFT JOIN categories ON books.categoryid = categories.categoryid
                          WHERE categories.name = '$category'";
                $result = $db->query($query);
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    return $row['row_count'];
                }
                return 1; // Default to 1 if no rows found
            }
            ?>
        </tbody>
    </table>
    <a href="view_books_detail.php" class="btn btn-primary">Back</a>
</body>
</html>
