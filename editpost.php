<?php
session_start();
include 'header.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Retrieve the post ID from the URL
if (isset($_GET['post_id'])) {
    $post_id_to_edit = $_GET['post_id'];

    // Fetch the post data from the database based on the post ID
    $sql = "SELECT * FROM users_post WHERE post_id = ? AND user_id = ?";
    $stmt = $link->prepare($sql);

    if (!$stmt) {
        die("Error in prepare: " . $link->error);
    }

    $user_id = (int)$_SESSION['user_id'];

    $stmt->bind_param("ii", $post_id_to_edit, $user_id);

    if (!$stmt) {
        die("Error in bind_param: " . $stmt->error);
    }

    $stmt->execute();

    if ($stmt->errno) {
        die("Error in execute: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $stmt->close();

    // Check if a post with the given ID exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $post_title = $row['post_title'];
        $post_content = $row['post_contents'];
    } else {
        // Handle the case where the post does not exist
        echo "Post not found.";
        exit;
    }

    //Edit function
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_title = $_POST['title'];
        $new_content = $_POST['content'];

        // Update the post data in the database
        $sql = "UPDATE users_post SET post_title = ?, post_contents = ? WHERE post_id = ? AND user_id = ?";
        $stmt = $link->prepare($sql);

        if (!$stmt) {
            die("Error in prepare: " . $link->error);
        }

        $stmt->bind_param("ssii", $new_title, $new_content, $post_id_to_edit, $user_id);

        if (!$stmt) {
            die("Error in bind_param: " . $stmt->error);
        }

        $stmt->execute();

        if ($stmt->errno) {
            die("Error in execute: " . $stmt->error);
        }

        $stmt->close();

        // Redirect after successful update
        header("Location: index.php");
        exit;
    }
} else {
    // Handle the case where post_id is not provided in the URL
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
        <label class="container-title">Edit Post - <?php echo $post_title; ?></label>
        <form method="POST" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" name="title" id="title" placeholder="title" value="<?php echo $post_title; ?>">
                <label class="text-muted">Enter New Title</label>
            </div>
            <div class="form-floating mb-3">
                <textarea placeholder="content" class="form-control rounded-0 border-top-0 border-end-0 border-start-0" style="height: 100px" name="content" id="content"><?php echo $post_content; ?></textarea>
                <label class="text-muted">Enter New Content</label>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-secondary">SAVE</button>
            </div>
        </form>
    </div>
</body>