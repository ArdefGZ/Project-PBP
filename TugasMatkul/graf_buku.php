<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas PBP - Koneksi ke Basis Data</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style/graf_buku_styles.css">
</head>
<body>
    <div class="container">
        <h1 class="page-title">Rekap Data Buku</h1> <!-- Tambahkan judul di sini -->
        <div style="width: 80%; margin: 0 auto;">
            <canvas id="bookChart"></canvas>
        </div>

        <?php
        // Include your database connection code here
        require_once('db_login.php');
        // Retrieve data for categories and books
        $categories = []; // Store category names
        $bookCounts = []; // Store book counts for each category
        $orderedCounts = []; // Store ordered book counts for each category

        // Query to get category names
        $categoryQuery = "SELECT name FROM categories";
        $resultCategory = $db->query($categoryQuery);

        if (!$resultCategory) {
            die("Could not query the database: <br />" . $db->error . "<br>Query: " . $categoryQuery);
        }

        while ($rowCategory = $resultCategory->fetch_assoc()) {
            $categories[] = $rowCategory['name'];
        }

        // Loop through categories and calculate book counts and ordered book counts
        foreach ($categories as $category) {
            // Query to count books in this category
            $categoryId = mysqli_real_escape_string($db, $category);
            $bookCountQuery = "SELECT COUNT(*) AS count FROM books WHERE categoryid = (SELECT categoryid FROM categories WHERE name = '$categoryId')";
            $resultBookCount = $db->query($bookCountQuery);

            if (!$resultBookCount) {
                die("Could not query the database: <br />" . $db->error . "<br>Query: " . $bookCountQuery);
            }

            $rowBookCount = $resultBookCount->fetch_assoc();
            $bookCounts[] = $rowBookCount['count'];

            // Query to count ordered books in this category
            $orderedCountQuery = "SELECT SUM(quantity) AS ordered_count FROM order_items INNER JOIN books ON order_items.isbn = books.isbn WHERE books.categoryid = (SELECT categoryid FROM categories WHERE name = '$categoryId')";
            $resultOrderedCount = $db->query($orderedCountQuery);

            if (!$resultOrderedCount) {
                die("Could not query the database: <br />" . $db->error . "<br>Query: " . $orderedCountQuery);
            }

            $rowOrderedCount = $resultOrderedCount->fetch_assoc();
            $orderedCounts[] = $rowOrderedCount['ordered_count'];
        }

        // Close the database connection
        $db->close();

        // Convert data to JSON format for Chart.js
        $categoryNamesJSON = json_encode($categories);
        $bookCountsJSON = json_encode($bookCounts);
        $orderedCountsJSON = json_encode($orderedCounts);
        ?>

        <script>
        // JavaScript code for creating the chart
        var ctx = document.getElementById('bookChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $categoryNamesJSON; ?>,
                datasets: [
                    {
                        label: 'Jumlah Data Buku',
                        data: <?php echo $bookCountsJSON; ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Data Buku yang Diorder',
                        data: <?php echo $orderedCountsJSON; ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        </script>
    </div>
</body>
</html>
