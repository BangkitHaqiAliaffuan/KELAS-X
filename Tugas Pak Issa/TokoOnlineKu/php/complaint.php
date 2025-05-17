<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You need to login first.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint = $_POST['complaint'];
    $image = $_FILES['image']['name'];
    $user_id = $_SESSION['user_id'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $sql = "INSERT INTO complaints (user_id, complaint, image) VALUES ($user_id, '$complaint', '$image')";
    if ($conn->query($sql) === TRUE) {
        echo "Complaint submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>