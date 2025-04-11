<?php
// pages/add_product.php

function uploadProductImages($product_id, $files, $max_images = 3) {
    global $conn;
    
    // Validation
    if (!is_numeric($product_id) || $product_id <= 0) {
        throw new Exception("Invalid product ID");
    }

    // Configure upload settings
    $target_dir = "../produkImg/";
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_file_size = 5 * 1024 * 1024; // 5MB
    
    // Create upload directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    $uploaded_images = 0;
    $errors = [];
    
    // Prepare the SQL statement once
    $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_url) VALUES (?, ?)");
    
    // Handle multiple file uploads
    foreach ($files['tmp_name'] as $key => $tmp_name) {
        // Skip if maximum number of images reached
        if ($uploaded_images >= $max_images) {
            break;
        }
        
        // Skip empty uploads
        if (empty($tmp_name)) {
            continue;
        }
        
        // Validate file
        $file_type = $files['type'][$key];
        $file_size = $files['size'][$key];
        $file_error = $files['error'][$key];
        
        if ($file_error !== UPLOAD_ERR_OK) {
            $errors[] = "Upload error for file " . $files['name'][$key];
            continue;
        }
        
        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Invalid file type for " . $files['name'][$key];
            continue;
        }
        
        if ($file_size > $max_file_size) {
            $errors[] = "File too large: " . $files['name'][$key];
            continue;
        }
        
        // Generate unique filename
        $file_extension = pathinfo($files['name'][$key], PATHINFO_EXTENSION);
        $new_filename =  $files['name'][$key];
        $target_file = $target_dir . $new_filename;
        
        // Move uploaded file
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Store in database
            $image_url = 'produkImg/' . $new_filename;
            
            if ($stmt->bind_param('is', $product_id, $image_url)) {
                if ($stmt->execute()) {
                    $uploaded_images++;
                } else {
                    $errors[] = "Database error for " . $files['name'][$key];
                    // Remove uploaded file if database insert fails
                    unlink($target_file);
                }
            } else {
                $errors[] = "Database binding error for " . $files['name'][$key];
                unlink($target_file);
            }
        } else {
            $errors[] = "Failed to move uploaded file: " . $files['name'][$key];
        }
    }
    
    $stmt->close();
    
    return [
        'success' => $uploaded_images > 0,
        'uploaded_count' => $uploaded_images,
        'errors' => $errors
    ];
}

// Replace the existing product insertion code with this:

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle file upload
    $target_dir = "../uploads/";
    $image = "";

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    // Prepare the statement for product insertion
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category_id, image, release_status) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssidss", 
            $_POST['name'],
            $_POST['description'],
            $_POST['price'],
            $_POST['category_id'],
            $image,
            $_POST['release_status']
        );

        // Execute the statement
        if ($stmt->execute()) {
            $product_id = $conn->insert_id;
            
            // Handle multiple image uploads
            if (isset($_FILES['product_images'])) {
                try {
                    $upload_result = uploadProductImages($product_id, $_FILES['product_images']);
                    
                    if ($upload_result['success']) {
                        echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Game and images added successfully!'
                            }).then(() => {
                                window.location = '?page=products';
                            });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({
                                icon: 'warning',
                                title: 'Partial Success',
                                text: 'Game added but some images failed to upload: " . 
                                implode(", ", $upload_result['errors']) . "'
                            });
                        </script>";
                    }
                } catch (Exception $e) {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error uploading images: " . $e->getMessage() . "'
                        });
                    </script>";
                }
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add game: " . $stmt->error . "'
                });
            </script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to prepare statement: " . $conn->error . "'
            });
        </script>";
    }
}

// Get categories for dropdown
$categories_query = "SELECT * FROM categories ORDER BY name";
$categories_result = $conn->query($categories_query);
?>

<div class="card">
    <div class="card-body">
        <h2 class="card-title">Add New Game</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Game Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <?php while ($category = $categories_result->fetch_assoc()): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Game Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Release Status</label>
                <select name="release_status" class="form-control" required>
                    <option value="released">Released</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="beta">Beta</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Game Images (Max 3)</label>
                <input type="file" name="product_images[]" class="form-control" accept="image/*" multiple required>
                <small class="text-muted">You can select up to 3 images</small>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-epic">Add Game</button>
                <a href="?page=products" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php 
