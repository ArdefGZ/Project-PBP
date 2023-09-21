<?php
// Deskripsi: Menampilkan form login dan melakukan login ke halaman admin.php

session_start(); // Inisialisasi session
require_once('db_login.php');

// Cek apakah user sudah submit form
if (isset($_POST["submit"])) {
    $valid = TRUE; // Flag validasi

    // Cek validasi email
    if (isset($_POST['email'])) {
        $email = test_input($_POST['email']);
        if ($email == '') {
            $error_email = "Email is required";
            $valid = FALSE;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_email = "Invalid email format";
            $valid = FALSE;
        }
    } else {
        $valid = FALSE;
    }

    // Cek validasi password
    if (isset($_POST['password'])) {
        $password = test_input($_POST['password']);
        if ($password == '') {
            $error_password = "Password is required";
            $valid = FALSE;
        }
    } else {
        $valid = FALSE;
    }

    // Cek validasi
    if ($valid) {
        // Assign a query
        $query = "SELECT * FROM admin WHERE email='" . $email . "' AND password='" . $password . "'";
        // Execute the query
        $result = $db->query($query);
        if (!$result) {
            die("Could not query the database: <br />" . $db->error);
        } else {
            if ($result->num_rows > 0) { // Login berhasil
                $_SESSION['username'] = $email;
                header('Location: view_books_detail.php');
                exit;
            } else { // Login gagal
                echo '<span class="error">Combination of username and password are not correct.</span>';
            }
        }
        // Close db connection
        $db->close();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="style/login_styles.css">
</head>

<body>
    <div class="login">
        <img src="img/login-bg.jpg" alt="image" class="login__bg">
        <form method="POST" class="login__form" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1 class="login__title">Login</h1>
            <div class="login__inputs">
                <div class="login__box">
                    <input type="email" placeholder="Email ID" required class="login__input" name="email" id="email" value="<?php if (isset($email)) echo $email; ?>" autocomplete="off">
                    <i class="ri-mail-fill"></i>
                    <div class="text-danger"><?php if (isset($error_email)) echo $error_email; ?></div>
                </div>

                <div class="login__box">
                    <input type="password" placeholder="Password" required class="login__input" id="password" name="password">
                    <i class="ri-lock-2-fill"></i>
                    <div class="text-danger"><?php if (isset($error_password)) echo $error_password; ?></div>
                </div>
            </div>


            <button type="submit" class="login__button" name="submit" value="submit">Login</button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>