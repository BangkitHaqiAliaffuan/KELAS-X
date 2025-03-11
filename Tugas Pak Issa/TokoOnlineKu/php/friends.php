<?php
include 'config.php';
// Database connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debug mode - set to true to see query results
$debug = false;

// Set default view to 'manage' if not specified
$view = isset($_GET['view']) ? $_GET['view'] : 'manage';

// Handle friend request action
if (isset($_POST['action']) && isset($_POST['friend_id'])) {
    $friend_id = $conn->real_escape_string($_POST['friend_id']);
    $user_id = $conn->real_escape_string($_SESSION['user_id']); // Assuming user is logged in
    
    if ($_POST['action'] == 'add') {
        // Check if friendship already exists
        $check_query = "SELECT * FROM friends WHERE 
                        (user_id = '$user_id' AND friend_id = '$friend_id') OR 
                        (user_id = '$friend_id' AND friend_id = '$user_id')";
        $check_result = $conn->query($check_query);
        
        if ($check_result->num_rows == 0) {
            // Insert new friend request
            $insert_query = "INSERT INTO friends (user_id, friend_id, status, created_at) 
                            VALUES ('$user_id', '$friend_id', 'pending', NOW())";
            
            if ($conn->query($insert_query) === TRUE) {
                echo "<script>alert('Friend request sent successfully.');</script>";
            } else {
                echo "<script>alert('Error sending friend request: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Friendship already exists or pending.');</script>";
        }
    } elseif ($_POST['action'] == 'accept') {
        // Accept friend request
        $update_query = "UPDATE friends SET status = 'accepted' 
                        WHERE friend_id = '$user_id' AND user_id = '$friend_id' AND status = 'pending'";
        
        if ($conn->query($update_query) === TRUE) {
            echo "<script>alert('Friend request accepted.');</script>";
        } else {
            echo "<script>alert('Error accepting friend request: " . $conn->error . "');</script>";
        }
    } elseif ($_POST['action'] == 'reject') {
        // Reject friend request
        $delete_query = "DELETE FROM friends 
                        WHERE friend_id = '$user_id' AND user_id = '$friend_id' AND status = 'pending'";
        
        if ($conn->query($delete_query) === TRUE) {
            echo "<script>alert('Friend request rejected.');</script>";
        } else {
            echo "<script>alert('Error rejecting friend request: " . $conn->error . "');</script>";
        }
    } elseif ($_POST['action'] == 'remove') {
        // Remove friendship
        $delete_query = "DELETE FROM friends WHERE 
                        (user_id = '$user_id' AND friend_id = '$friend_id') OR 
                        (user_id = '$friend_id' AND friend_id = '$user_id')";
        
        if ($conn->query($delete_query) === TRUE) {
            echo "<script>alert('Friend removed successfully.');</script>";
        } else {
            echo "<script>alert('Error removing friend: " . $conn->error . "');</script>";
        }
    }
}

// Get user ID from session (assuming user is logged in)
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Query for user's friends (for manage view)
$friends_query = "
    SELECT f.*, 
           u.username AS friend_name, 
           u.email AS friend_email, 
           u.profile_image AS friend_image,
           CASE 
               WHEN f.user_id = '$current_user_id' THEN 'sent'
               WHEN f.friend_id = '$current_user_id' THEN 'received'
           END AS request_type
    FROM friends f
    LEFT JOIN users u ON (
        CASE 
            WHEN f.user_id = '$current_user_id' THEN u.id = f.friend_id
            WHEN f.friend_id = '$current_user_id' THEN u.id = f.user_id
        END
    )
    WHERE f.user_id = '$current_user_id' OR f.friend_id = '$current_user_id'
    ORDER BY f.status ASC, f.created_at DESC";

$friends_result = $conn->query($friends_query);

// Query for pending received requests only (for requests view)
$requests_query = "
    SELECT f.*, 
           u.id AS friend_id,
           u.username AS friend_name, 
           u.email AS friend_email, 
           u.profile_image AS friend_image
    FROM friends f
    LEFT JOIN users u ON f.user_id = u.id
    WHERE f.friend_id = '$current_user_id' 
    AND f.status = 'pending'
    ORDER BY f.created_at DESC";

$requests_result = $conn->query($requests_query);
$pending_count = $requests_result->num_rows;

// Query for available users (for add view)
$users_query = "
    SELECT u.id, u.username, u.email, u.profile_image
    FROM users u
    WHERE u.id != '$current_user_id'
    AND u.id NOT IN (
        SELECT CASE 
            WHEN f.user_id = '$current_user_id' THEN f.friend_id
            WHEN f.friend_id = '$current_user_id' THEN f.user_id
        END
        FROM friends f
        WHERE (f.user_id = '$current_user_id' OR f.friend_id = '$current_user_id')
          AND (f.status = 'accepted' OR f.status = 'pending')
    )
    ORDER BY u.username ASC";

$users_result = $conn->query($users_query);

// Debug information
if ($debug) {
    if (!$friends_result) {
        echo "Error in friends query: " . $conn->error . "<br>";
    }
    if (!$users_result) {
        echo "Error in users query: " . $conn->error . "<br>";
    }
    if (!$requests_result) {
        echo "Error in requests query: " . $conn->error . "<br>";
    }
    
    $friends_count = $friends_result ? $friends_result->num_rows : 0;
    $users_count = $users_result ? $users_result->num_rows : 0;
    $requests_count = $requests_result ? $requests_result->num_rows : 0;
    
    echo "Number of friends/requests: " . $friends_count . "<br>";
    echo "Number of pending requests: " . $requests_count . "<br>";
    echo "Number of available users: " . $users_count . "<br>";
}

// Function to get user initials from username
function getUserInitials($username) {
    $words = explode(' ', $username);
    $initials = '';
    
    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper(mb_substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
        }
    }
    
    if (strlen($initials) < 1) {
        $initials = strtoupper(mb_substr($username, 0, 1));
    }
    
    return $initials;
}

// Function to generate a random color
function getRandomColor($username) {
    // Use the username as a seed to ensure the same user always gets the same color
    $seed = crc32($username);
    srand($seed);
    
    // Define a set of vibrant background colors
    $colors = [
        '#f44336', // red
        '#e91e63', // pink
        '#9c27b0', // purple
        '#673ab7', // deep purple
        '#3f51b5', // indigo
        '#2196f3', // blue
        '#03a9f4', // light blue
        '#00bcd4', // cyan
        '#009688', // teal
        '#4caf50', // green
        '#8bc34a', // light green
        '#cddc39', // lime
        '#ffc107', // amber
        '#ff9800', // orange
        '#ff5722'  // deep orange
    ];
    
    $colorIndex = rand(0, count($colors) - 1);
    return $colors[$colorIndex];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --epic-bg: #121212;
            --epic-card-bg: #202020;
            --epic-text: #ffffff;
            --epic-secondary: #2a2a2a;
            --epic-hover: #303030;
            --epic-blue: #037BEF;
            --epic-accent: #037BEF;
            --epic-danger: #dc3545;
            --epic-success: #28a745;
            --epic-warning: #ffc107;
            --epic-purple: #6c5ce7;
        }
        
        body {
            background-color: var(--epic-bg);
            color: var(--epic-text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.5;
        }
        
        .container-fluid {
            max-width: 1800px;
            padding: 2rem;
        }
        
        h2.mb-4 {
            color: var(--epic-text);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2.5rem !important;
            letter-spacing: 0.5px;
        }
        
        .nav-tabs {
            border-bottom: 1px solid var(--epic-secondary);
            margin-bottom: 2rem;
        }
        
        .nav-tabs .nav-link {
            color: var(--epic-text);
            border: none;
            border-radius: 10px 10px 0 0;
            padding: 1rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
            margin-right: 0.5rem;
        }
        
        .nav-tabs .nav-link:hover {
            background-color: var(--epic-hover);
            border-color: transparent;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--epic-text);
            background-color: var(--epic-card-bg);
            border-color: transparent;
            border-bottom: 3px solid var(--epic-blue);
        }
        
        .card {
            background-color: var(--epic-card-bg);
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .card:hover {
            transform: translateY(-3px);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-title {
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .friend-card {
            display: flex;
            align-items: center;
        }
        
        .friend-image {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1.5rem;
            border: 3px solid var(--epic-secondary);
        }
        
        .friend-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-right: 1.5rem;
            border: 3px solid var(--epic-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.5rem;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
        
        .friend-info {
            flex-grow: 1;
        }
        
        .friend-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .friend-email {
            color: #9a9a9a;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--epic-blue);
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #0366d6;
            transform: translateY(-1px);
        }
        
        .btn-success {
            background-color: var(--epic-success);
            border: none;
        }
        
        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }
        
        .btn-danger {
            background-color: var(--epic-danger);
            border: none;
        }
        
        .btn-danger:hover {
            background-color: #bb2d3b;
            transform: translateY(-1px);
        }
        
        .btn-warning {
            background-color: var(--epic-warning);
            border: none;
            color: #212529;
        }
        
        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-1px);
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .badge {
            padding: 0.5rem 0.8rem;
            border-radius: 6px;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }
        
        .badge-pending {
            background-color: var(--epic-warning);
            color: #212529;
        }
        
        .badge-accepted {
            background-color: var(--epic-success);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            background-color: var(--epic-hover);
            border-radius: 12px;
            margin: 2rem 0;
        }
        
        .empty-state-icon {
            font-size: 3rem;
            color: #9a9a9a;
            margin-bottom: 1.5rem;
        }
        
        .empty-state-text {
            color: #9a9a9a;
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }
        
        .notifications-badge {
            background-color: var(--epic-danger);
            color: white;
            border-radius: 50%;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
            display: inline-block;
        }
        
        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            h2.mb-4 {
                font-size: 1.5rem;
            }
            
            .nav-tabs .nav-link {
                padding: 0.8rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .friend-image, .friend-avatar {
                width: 50px;
                height: 50px;
                margin-right: 1rem;
                font-size: 1.2rem;
            }
            
            .friend-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <h2 class="mb-4">Friends</h2>
        
        <!-- Navigation tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?= $view == 'manage' ? 'active' : '' ?>" href="?menu=friends&view=manage">
                    <i class="fas fa-user-friends me-2"></i> My Friends
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $view == 'requests' ? 'active' : '' ?>" href="?menu=friends&view=requests">
                    <i class="fas fa-user-clock me-2"></i> Friend Requests
                    <?php if ($pending_count > 0): ?>
                        <span class="notifications-badge"><?= $pending_count ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $view == 'add' ? 'active' : '' ?>" href="?menu=friends&view=add">
                    <i class="fas fa-user-plus me-2"></i> Add Friend
                </a>
            </li>
        </ul>
        
        <!-- Content area -->
        <div class="tab-content">
            <?php if ($view == 'manage'): ?>
                <!-- Manage Friends View -->
                <div class="row">
                    <?php 
                    $has_friends = false;
                    
                    if ($friends_result && $friends_result->num_rows > 0): 
                        while ($friend = $friends_result->fetch_assoc()): 
                            // Only show accepted friends in the manage view
                            if ($friend['status'] == 'accepted') {
                                $has_friends = true;
                                
                                // Get appropriate display values based on request type
                                $friend_id = ($friend['request_type'] == 'sent') ? $friend['friend_id'] : $friend['user_id'];
                                $has_profile_image = !empty($friend['friend_image']);
                                $initials = getUserInitials($friend['friend_name']);
                                $bgColor = getRandomColor($friend['friend_name']);
                    ?>
                        <div class="col-lg-6 col-xl-4">
                            <div class="card">
                                <div class="card-body friend-card">
                                    <?php if ($has_profile_image): ?>
                                        <img src="uploads/profiles/<?= $friend['friend_image'] ?>" 
                                             alt="<?= htmlspecialchars($friend['friend_name']) ?>" 
                                             class="friend-image">
                                    <?php else: ?>
                                        <div class="friend-avatar" style="background-color: <?= $bgColor ?>;">
                                            <?= $initials ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="friend-info">
                                        <h5 class="card-title">
                                            <?= htmlspecialchars($friend['friend_name']) ?>                                           
                                            <span class="badge badge-accepted">Friend</span>
                                        </h5>
                                        
                                        <div class="friend-email">
                                            <?= htmlspecialchars($friend['friend_email']) ?>
                                        </div>
                                        
                                        <div class="friend-actions">
                                            <a href="?page=chat&user_id=<?= $friend_id ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-comment me-1"></i> Message
                                            </a>
                                            
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="friend_id" value="<?= $friend_id ?>">
                                                <input type="hidden" name="action" value="remove">
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to remove this friend?');">
                                                    <i class="fas fa-user-minus me-1"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                            }
                        endwhile; 
                    endif;
                    
                    if (!$has_friends):
                    ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="empty-state-text">
                                You don't have any friends yet.
                            </div>
                            <a href="?menu=friends&view=add" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i> Find Friends
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($view == 'requests'): ?>
                <!-- Friend Requests View -->
                <div class="row">
                    <?php 
                    $has_requests = false;
                    
                    if ($requests_result && $requests_result->num_rows > 0): 
                        $has_requests = true;
                        while ($request = $requests_result->fetch_assoc()): 
                            $has_profile_image = !empty($request['friend_image']);
                            $initials = getUserInitials($request['friend_name']);
                            $bgColor = getRandomColor($request['friend_name']);
                    ?>
                        <div class="col-lg-6 col-xl-4">
                            <div class="card">
                                <div class="card-body friend-card">
                                    <?php if ($has_profile_image): ?>
                                        <img src="uploads/profiles/<?= $request['friend_image'] ?>" 
                                             alt="<?= htmlspecialchars($request['friend_name']) ?>" 
                                             class="friend-image">
                                    <?php else: ?>
                                        <div class="friend-avatar" style="background-color: <?= $bgColor ?>;">
                                            <?= $initials ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="friend-info">
                                        <h5 class="card-title">
                                            <?= htmlspecialchars($request['friend_name']) ?>
                                            <span class="badge badge-pending">Pending</span>
                                        </h5>
                                        
                                        <div class="friend-email">
                                            <?= htmlspecialchars($request['friend_email']) ?>
                                        </div>
                                        
                                        <div class="friend-actions">
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="friend_id" value="<?= $request['friend_id'] ?>">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check me-1"></i> Accept
                                                </button>
                                            </form>
                                            
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="friend_id" value="<?= $request['friend_id'] ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times me-1"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endwhile; 
                    endif;
                    
                    if (!$has_requests):
                    ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="empty-state-text">
                                No pending friend requests.
                            </div>
                            <a href="?menu=friends&view=add" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i> Find Friends
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php else: ?>
                <!-- Add Friend View -->
                <div class="row">
                    <?php if ($users_result && $users_result->num_rows > 0): ?>
                        <?php while ($user = $users_result->fetch_assoc()): 
                            $has_profile_image = !empty($user['profile_image']);
                            $initials = getUserInitials($user['username']);
                            $bgColor = getRandomColor($user['username']);
                        ?>
                            <div class="col-lg-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body friend-card">
                                        <?php if ($has_profile_image): ?>
                                            <img src="./uploads/profiles/<?= $user['profile_image'] ?>" 
                                                 alt="<?= htmlspecialchars($user['username']) ?>" 
                                                 class="friend-image">
                                        <?php else: ?>
                                            <div class="friend-avatar" style="background-color: <?= $bgColor ?>;">
                                                <?= $initials ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="friend-info">
                                            <h5 class="card-title">
                                                <?= htmlspecialchars($user['username']) ?>
                                            </h5>
                                            
                                            <div class="friend-email">
                                                <?= htmlspecialchars($user['email']) ?>
                                            </div>
                                            
                                            <div class="friend-actions">
                                                <form method="post">
                                                    <input type="hidden" name="friend_id" value="<?= $user['id'] ?>">
                                                    <input type="hidden" name="action" value="add">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-user-plus me-1"></i> Send Request
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="empty-state-text">
                                No users available to add as friends.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>