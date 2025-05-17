<?php
// pages/users.php
$query = "SELECT * FROM users ORDER BY id ASC";
$result = $conn->query($query);
?>

<h2 class="mb-4">Manage Users</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= $row['role'] ?></td>
                            <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                            <td>
                                <a href="?page=manage_users&id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-primary">Edit</a>
                                <button onclick="deleteUser(<?= $row['id'] ?>)" 
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
function deleteUser(id) {
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
            window.location.href = `delete_user.php?id=${id}`;
        }
    });
}
</script>
