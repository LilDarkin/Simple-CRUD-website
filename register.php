<?php
session_start();
include 'header.php';


if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['userpassword'];
    $cpassword = $_POST['confirmpassword'];

    if ($cpassword == $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (user_name, user_email, user_pass) VALUES (?, ?, ?)";
        $stmt = $link->prepare($sql);

        // Check for errors after prepare
        if (!$stmt) {
            die("Error in prepare: " . $link->error);
        }

        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Check for errors after bind_param
        if (!$stmt) {
            die("Error in bind_param: " . $link->error);
        }

        $stmt->execute();

        // Check for errors after execute
        if ($stmt->errno) {
            die("Error in execute: " . $stmt->error);
        }
        $stmt->close();
        // Redirect after successful registration
        header("Location: login.php");
        exit;
    } else {
        echo "Password doesn't matched!";
    }
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

        .title {
            display: grid;
            place-items: center;
        }

        .container-title {
            font-size: 25px;
            margin: 10 0 0 10;
        }
    </style>
</head>

<body>
    <div class="title"><label class="container-title">Register</label></div>
    <div class="container">
        <label class="container-title">See the Registration Rules</label>
        <hr>
        <form method="POST" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="username" id="username" placeholder="Username">
                <label class="text-muted">Enter Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="email" id="email" placeholder="Email">
                <label class="text-muted">Enter Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" placeholder="Password" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="userpassword" id="userpassword">
                <label class="text-muted">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" placeholder="Confirm Password" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="confirmpassword" id="confirmpassword">
                <label class="text-muted">Confirm Password</label>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-secondary">Register</button>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-check-label" for="exampleCheck1">Return to the <a href="login.php" class="text-warning text-decoration-none">LOGIN PAGE</a></label>
            </div>
        </form>
    </div>

</body>