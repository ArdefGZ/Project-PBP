<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tugas PBP - Koneksi ke Basis Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style/order_date_style.css">
</head>
<body>
    <div class="container">
        <br>
        <h1>Orders Report</h1>
        <form method="GET">
            <div class="row mb-3">
                <div class="col">
                    <label for="start_date">Start Date:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                </div>
                <div class="col">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                </div>
                <div class="col">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </div>
        </form>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a> <!-- Tombol "back" -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection
                require_once('db_login.php');

                // Initialize query
                $query = "SELECT o.orderid, c.name AS customer_name, o.amount, o.date
                          FROM orders o
                          JOIN customers c ON o.customerid = c.customerid";

                // Check if start_date is set and not empty
                if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
                    $start_date = $_GET['start_date'];
                    $query .= " WHERE o.date >= '$start_date'";
                }

                // Check if end_date is set and not empty
                if (isset($_GET['end_date']) && !empty($_GET['end_date'])) {
                    $end_date = $_GET['end_date'];
                    // If a WHERE clause already exists, use AND, otherwise use WHERE
                    $query .= isset($start_date) ? " AND o.date <= '$end_date'" : " WHERE o.date <= '$end_date'";
                }

                $query .= " ORDER BY o.orderid";

                $result = $db->query($query);

                if (!$result) {
                    die("Could not query the database: <br />" . $db->error);
                }

                while ($row = $result->fetch_object()) {
                    echo '<tr>';
                    echo '<td>' . $row->orderid . '</td>';
                    echo '<td>' . $row->customer_name . '</td>';
                    echo '<td>$' . $row->amount . '</td>';
                    echo '<td>' . $row->date . '</td>';
                    echo '</tr>';
                }

                $result->free();
                $db->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
