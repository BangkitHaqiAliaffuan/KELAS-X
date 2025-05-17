
<!-- edit_product.php -->
<div class="container mt-4">
    <h2>Edit Product</h2>

    <?php

    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);  // Remove error after displaying
    }

     if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);  // Remove success after displaying
    }

    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    // Get product images
    $stmt = $conn->prepare("SELECT * FROM product_images WHERE product_id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    ?>

    <form action="pages/update_product.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product_id ?>">

        <div class="card mb-4">
            <div class="card-header">
                <h5>Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?= htmlspecialchars($product['name']) ?>">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                    ><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price"
                           value="<?= $product['price'] ?>">
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <?php
                        $categories = $conn->query("SELECT * FROM categories");
                        while ($category = $categories->fetch_assoc()):
                        ?>
                            <option value="<?= $category['id'] ?>"
                                <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="release_status" class="form-label">Status</label>
                    <select class="form-control" id="release_status" name="release_status">
                        <option value="released" <?= $product['release_status'] == 'released' ? 'selected' : '' ?>>
                            Released
                        </option>
                        <option value="upcoming" <?= $product['release_status'] == 'upcoming' ? 'selected' : '' ?>>
                            Upcoming
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Product Images</h5>
            </div>
            <div class="card-body">
                <!-- Current Images -->
                <div class="mb-3">
                    <label class="form-label">Current Images</label>
                    <div class="row">
                        <?php foreach ($images as $image): ?>
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img src="../<?= htmlspecialchars($image['image_url']) ?>"
                                         class="card-img-top" alt="Product Image"
                                         style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="delete_images[]" value="<?= $image['id'] ?>">
                                            <label class="form-check-label">Delete</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Upload New Images -->
                <div class="mb-3">
                    <label for="images" class="form-label">Add New Images</label>
                    <input type="file" class="form-control" id="images" name="images[]"
                           multiple accept="image/*">
                    <small class="text-muted">You can select multiple images</small>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="index.php?page=products" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
