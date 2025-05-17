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
        echo "User  not found.";
        exit();
    }
} else {
    echo "You must be logged in to view this page.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Profile - Gramedia</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #e9ecef; /* Light background for contrast */
        }
        .profile-container {
            display: flex;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            overflow: hidden;
        }
        .profile-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0; /* Placeholder background */
        }
        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%; /* Circular image */
            border: 4px solid #007bff; /* Border around the image */
        }
        .profile-info {
            flex: 2;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .profile-info h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .profile-info p {
            color: #555;
            margin: 5px 0;
            font-size: 16px;
        }
        .profile-info .email {
            font-weight: 500;
            color: #007bff; /* Link color */
        }
        .edit-profile-link {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: 500;
            align-self: flex-start; /* Align to the left */
        }
        .edit-profile-link:hover {
            background-color: #0056b3; /* Darker blue on hover */
            transform: translateY(-2px); /* Slight lift effect */
        }
        .social-icons {
            margin-top: 20px;
        }
        .social-icons a {
            margin: 0 10px;
            color: #007bff;
            font-size: 24px;
            transition: color 0.3s ease;
        }
        .social-icons a:hover {
            color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <div class="profile-image">
            <img src="<?php echo !empty($user['gambar_profile']) ? $user['gambar_profile'] : 'uploads/avatar female.svg'; ?>" alt="Profile Picture"/>
        </div>
        <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['nama']); ?></h2>
            <p class="email"><?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Description:</strong></p>
            <p><?php echo htmlspecialchars($user['deskripsi']); ?></p>
            <a href="?menu=edit_profile" class="edit-profile-link">Edit Profile</a>

            <div class="social-icons">
                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</body>

</html>