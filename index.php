<?php
session_start();
include 'header.php';

//Check if logged and get user posts
if (isset($_SESSION['user_id'])) {
    // Fetch posts from the database
    $sql = "SELECT * FROM users_post WHERE user_id = ?";
    $stmt = $link->prepare($sql);

    if (!$stmt) {
        die("Error in prepare: " . $link->error);
    }

    $user_id = (int)$_SESSION['user_id'];

    $stmt->bind_param("i", $user_id);

    if (!$stmt) {
        die("Error in bind_param: " . $stmt->error);
    }

    $stmt->execute();

    if ($stmt->errno) {
        die("Error in execute: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $stmt->close();

    //Delete post function
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_post'])) {
        $post_id = $_POST['post_id'];

        // Delete the post from the database
        $sql = "DELETE FROM users_post WHERE post_id = ? AND user_id = ?";
        $stmt = $link->prepare($sql);

        if (!$stmt) {
            die("Error in prepare: " . $link->error);
        }

        $stmt->bind_param("ii", $post_id, $_SESSION['user_id']);

        if (!$stmt) {
            die("Error in bind_param: " . $stmt->error);
        }

        $stmt->execute();

        if ($stmt->errno) {
            die("Error in execute: " . $stmt->error);
        }

        header("Location: index.php");
    }
}

?>

<head>
    <style>
        .posts {
            width: 100%;
            height: fit-content;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 7px 2px rgba(0, 0, 0, 0.1);
            padding: 2px;
            margin-top: 10px;
        }

        .create-posts {
            width: 100%;
            height: fit-content;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 7px 2px rgba(0, 0, 0, 0.1);
            padding: 2px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container post">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="posts">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['post_title']; ?></h5>
                        <p class="card-text"><?php echo $row['post_contents']; ?></p>
                        <p class="card-text">Date: <?php echo date('jS \of F Y h:i:s A', strtotime($row['post_date'])); ?></p>
                        <hr>
                        <div class="options">
                            <form method="POST" action="">
                                <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">
                                <button type="submit" name="delete_post" class="btn btn-danger">Delete</button>
                                <a href="editpost.php?post_id=<?php echo $row['post_id']; ?>" class="btn btn-success">Edit</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    </div>

    <div class="container">
        <div class="create-posts">
            <div class="card border-0">
                <div class="card-body w-100">
                    <a href="newpost.php" class="btn btn-primary">CREATE NEW POST</a>
                </div>
            </div>
        </div>
    </div>
</body>