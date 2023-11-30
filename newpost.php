<?php
session_start();
include 'header.php';


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Insert the user into the database
    $sql = "INSERT INTO users_post (user_id, post_title, post_contents, post_date) VALUES (" . $_SESSION['user_id'] . ", ?, ?, NOW())";

    $stmt = $link->prepare($sql);

    // Check for errors after prepare
    if (!$stmt) {
        die("Error in prepare: " . $link->error);
    }

    $stmt->bind_param("ss", $title, $content);

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
    header("Location: index.php");
    exit;
}
?>

<head>
    <style>
        .container {
            width: 100%;
            height: fit-content;
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
        <label class="container-title">Create a POST</label>
        <form method="POST" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="title" id="title" placeholder="title">
                <label class="text-muted">Enter Title</label>
            </div>
            <div class="form-floating mb-3">
                <textarea placeholder="content" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" style="height: 100px" name="content" id="content"></textarea>
                <label class="text-muted">Enter Content</label>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-secondary">POST</button>
            </div>
        </form>
    </div>

</body>