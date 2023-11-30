<?php
$link = mysqli_connect("localhost", "root", "", "blogdb");

// Check connection
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}