<?php
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user information
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "You must be logged in to view this page.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['nama'];
    $description = $_POST['description'];

    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
        $profile_picture = $target_file;
    } else {
        // Use existing profile picture if no new upload
        $profile_picture = $user['gambar_profile'];
    }

    // Update user information
    $sql = "UPDATE user SET nama='$name', deskripsi='$description', gambar_profile='$profile_picture' WHERE email='$email'";
    
    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php?menu=profile");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Profile - Gramedia</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #e9ecef;
        }
        .edit-profile-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            padding: 30px;
        }
        .edit-profile-container h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .edit-profile-container input,
        .edit-profile-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .edit-profile-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-profile-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nama" placeholder="Nama Lengkap" value="<?php echo htmlspecialchars($user['nama']); ?>" required />
            
            <textarea name="description" placeholder="Description"><?php echo htmlspecialchars($user['deskripsi']); ?></textarea>
            
            <label for="profile_picture">Upload Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture"/>
            
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>

</html>
