<?php
session_start();
include 'header.php';


if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['userpassword'];

    // Retrieve hashed password from the database based on the email
    $sql = "SELECT * FROM users WHERE user_email = ?";
    $stmt = $link->prepare($sql);
    // Check for errors after prepare
    if (!$stmt) {
        die("Error in prepare: " . $link->error);
    }
    $stmt->bind_param("s", $email);
    // Check for errors after bind_param
    if (!$stmt) {
        die("Error in bind_param: " . $link->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['user_pass'];

        // Verify the entered password
        if (password_verify($password, $hashed_password)) {
            // Login successful
            $_SESSION["user_id"] = $row['user_id'];
            $_SESSION["username"] = $row['user_name'];
            header("Location: index.php");
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Invalid email or password";
    }

    $stmt->close();
}

?>

<head>
    <style>
        .container {
            width: 100%;
            height: fit-content;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 5px 5px 10px 5px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .container-title {
            font-size: 25px;
            margin: 10 0 0 10;
        }
    </style>
</head>

<body>
    <div class="container">
        <label class="container-title">Login</label>
        <hr>
        <form method="POST" action="">
            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="email" id="email" placeholder="Email">
                <label class="text-muted">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" placeholder="Password" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="userpassword" id="userpassword">
                <label class="text-muted">Password</label>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-secondary">Login</button>
                <button type="button" class="btn btn-secondary"><a href="register.php" class="text-decoration-none text-white">Register</a></button>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-check-label" for="exampleCheck1">Currently logged out.</label>
            </div>
        </form>
    </div>

</body>