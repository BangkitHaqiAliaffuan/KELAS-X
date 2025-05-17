<?php
// pages/products.php
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          ORDER BY p.id DESC";
$result = $conn->query($query);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Games</h2>
    <a href="?page=add_product" class="btn btn-epic">Add New Game</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <img src="../uploads/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                            <td>Rp. <?= number_format($row['price'], 2) ?></td>
                            <td><?= ucfirst($row['release_status']) ?></td>
                            <td>
                                <a href="?page=edit_product&id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-primary">Edit</a>
                                <button onclick="deleteProduct(<?= $row['id'] ?>)" 
                                        class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function deleteProduct(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `admin.php?page=delete_product&id=${id}`;
        }
    });
}
</script>