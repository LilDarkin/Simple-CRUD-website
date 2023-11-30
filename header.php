<?php
include 'connection.php';
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-light bg-primary">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold primary text-white">MiniBlog</a>
            <div class="d-flex gap-2">
                <?php if (isset($_SESSION['user_id'])) {
                ?>
                    <a class="navbar-brand primary text-white">Hi <?php echo $_SESSION["username"] ?>!</a>
                    <button class="btn text-white" type="submit"><a href="index.php" class="text-decoration-none text-white">Home</a></button>
                    <button class="btn text-white" type="submit"><a href="logout.php" class="text-decoration-none text-white">Logout</a></button>
                <?php } else { ?>
                    <button class="btn text-white" type="submit"><a href="login.php" class="text-decoration-none text-white">Login</a></button>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
</body>