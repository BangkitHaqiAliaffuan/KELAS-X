@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management - Ayam Goreng JOSS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #ff6b00;
            --primary-dark: #d84315;
            --primary-light: #ffab40;
            --accent-color: #e65100;
            --text-dark: #333333;
            --text-light: #f9f9f9;
            --background-light: #f8f9fa;
            --background-dark: #263238;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --info-color: #2196f3;
            --border-color: #e0e0e0;
            --card-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            --hover-transition: all 0.3s ease;
        }

        body {
            background-color: var(--background-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        .admin-content {
            padding: 30px;
        }

        .page-title {
            margin-bottom: 30px;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .admin-filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-label {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.9rem;
            background-color: white;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .filter-input {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .filter-button {
            padding: 8px 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--hover-transition);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-button:hover {
            background-color: var(--primary-dark);
        }

        .reset-button {
            padding: 8px 15px;
            background-color: #f1f1f1;
            color: var(--text-dark);
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .reset-button:hover {
            background-color: #e0e0e0;
        }

        .admin-table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th,
        .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table th {
            font-weight: 600;
            color: #555;
            background-color: #f9f9f9;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-table tr:hover td {
            background-color: #f9f9f9;
        }

        .admin-id {
            font-weight: 600;
            color: var(--primary-color);
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-name {
            font-weight: 500;
        }

        .admin-email {
            font-size: 0.85rem;
            color: #666;
        }

        .admin-role {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info-color);
        }

        .role-superadmin {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        .role-admin {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info-color);
        }

        .role-manager {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--warning-color);
        }

        .role-staff {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .admin-status {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-active {
            background-color: var(--success-color);
        }

        .status-inactive {
            background-color: #888;
        }

        .admin-actions {
            display: flex;
            gap: 10px;
        }

        .action-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            background-color: #f1f1f1;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .action-icon:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .action-icon.view:hover {
            background-color: var(--info-color);
        }

        .action-icon.edit:hover {
            background-color: var(--warning-color);
        }

        .action-icon.delete:hover {
            background-color: var(--danger-color);
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: white;
            border-top: 1px solid var(--border-color);
        }

        .pagination-info {
            font-size: 0.9rem;
            color: #666;
        }

        .pagination-controls {
            display: flex;
            gap: 5px;
        }

        .pagination-button {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background-color: white;
            color: var(--text-dark);
            font-weight: 500;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .pagination-button:hover {
            background-color: #f1f1f1;
        }

        .pagination-button.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination-button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .modal.active .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #888;
            transition: var(--hover-transition);
        }

        .modal-close:hover {
            color: var(--danger-color);
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-button {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .modal-button.primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .modal-button.primary:hover {
            background-color: var(--primary-dark);
        }

        .modal-button.secondary {
            background-color: #f1f1f1;
            color: var(--text-dark);
            border: none;
        }

        .modal-button.secondary:hover {
            background-color: #e0e0e0;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .admin-filters {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 768px) {
            .admin-main {
                margin-left: 70px;
            }

            .admin-content {
                padding: 20px 15px;
            }

            .admin-filters {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-group {
                width: 100%;
            }

            .filter-select,
            .filter-input {
                flex: 1;
            }

            .admin-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 576px) {
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .pagination {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="admin-content">
        <div class="admin-header">
            <h1 class="page-title">Admin Management</h1>
            <button class="filter-button" id="addAdminBtn">
                <i class="fas fa-plus"></i> Add New Admin
            </button>
        </div>

        <div class="admin-filters">
            <div class="filter-group">
                <label class="filter-label">Role:</label>
                <select class="filter-select">
                    <option value="">All Roles</option>
                    <option value="superadmin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Status:</label>
                <select class="filter-select">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Search:</label>
                <input type="text" class="filter-input" placeholder="Search by name or email...">
            </div>
            <button class="filter-button">
                <i class="fas fa-filter"></i> Filter
            </button>
            <button class="reset-button">Reset</button>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($admins) && count($admins) > 0)
                        @foreach ($admins as $admin)
                            <tr>
                                <td class="admin-id">#{{ str_pad($admin->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="admin-info">
                                        <div class="admin-avatar">{{ substr($admin->name, 0, 2) }}</div>
                                        <div>
                                            <div class="admin-name">{{ $admin->name }}</div>
                                            <div class="admin-email">{{ $admin->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="admin-role role-{{ strtolower($admin->role) }}">{{ $admin->role }}</span>
                                </td>
                                <td>
                                    <span class="admin-status status-{{ $admin->is_active ? 'active' : 'inactive' }}"></span>
                                    {{ $admin->is_active ? 'Active' : 'Inactive' }}
                                </td>
                                <td>{{ $admin->last_login ? $admin->last_login->format('Y-m-d H:i') : 'Never' }}</td>
                                <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="admin-actions">
                                        <div class="action-icon edit" data-id="{{ $admin->id }}"><i class="fas fa-edit"></i></div>
                                        <div class="action-icon delete" onclick="window.location.href = '{{ url('admin/'.$admin->id.'/delete') }}'"><i class="fas fa-trash"></i></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" style="text-align: center;">No admin users found</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if (isset($admins) && $admins->hasPages())
                <div class="pagination">
                    <div class="pagination-info">
                        Showing {{ $admins->firstItem() }} to {{ $admins->lastItem() }} of {{ $admins->total() }} entries
                    </div>
                    <div class="pagination-controls">
                        @if ($admins->onFirstPage())
                            <span class="pagination-button disabled">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $admins->previousPageUrl() }}" class="pagination-button">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        @php
                            $currentPage = $admins->currentPage();
                            $totalPages = $admins->lastPage();
                            $displayPages = 5; // Number of page buttons to show
                            $halfDisplay = floor($displayPages / 2);

                            $startPage = max(1, $currentPage - $halfDisplay);
                            $endPage = min($totalPages, $startPage + $displayPages - 1);

                            if ($endPage - $startPage + 1 < $displayPages) {
                                $startPage = max(1, $endPage - $displayPages + 1);
                            }
                        @endphp

                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $currentPage)
                                <span class="pagination-button active">{{ $page }}</span>
                            @else
                                <a href="{{ $admins->url($page) }}" class="pagination-button">{{ $page }}</a>
                            @endif
                        @endfor

                        @if ($admins->hasMorePages())
                            <a href="{{ $admins->nextPageUrl() }}" class="pagination-button">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="pagination-button disabled">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Admin Modal -->
    <div class="modal" id="adminModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add New Admin</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="adminForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="superadmin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="is_active" class="form-select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-button secondary">Cancel</button>
                        <input type="submit" class="modal-button primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
     document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('adminModal');
    const modalTitle = document.getElementById('modalTitle');
    const adminForm = document.getElementById('adminForm');
    const addAdminBtn = document.getElementById('addAdminBtn');
    const editBtns = document.querySelectorAll('.action-icon.edit');
    const closeModal = document.querySelector('.modal-close');
    const cancelButton = modal.querySelector('.modal-button.secondary');
    const passwordInput = document.getElementById('password');
    const passwordGroup = passwordInput.closest('.form-group');

    // Function to open modal for adding new admin
    function openAddAdminModal() {
        modalTitle.textContent = 'Add New Admin';
        adminForm.action = "{{ route('admin.store') }}"; // Laravel route for creating new admin
        adminForm.method = 'POST';

        // Show and reset password field for new admin
        passwordGroup.style.display = 'block';
        passwordInput.setAttribute('required', 'required');

        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('role').value = 'admin';
        document.getElementById('status').value = '1';

        modal.classList.add('active');
    }

    // Function to open modal for editing admin
    function openEditAdminModal(adminId) {
        modalTitle.textContent = 'Edit Admin';
        adminForm.action = `/admin/${adminId}`; // Route for updating admin
        adminForm.method = 'POST';

        // Hide password field for edit
        passwordGroup.style.display = 'none';
        passwordInput.removeAttribute('required');

        // Create hidden input for method spoofing
        let methodInput = document.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.setAttribute('type', 'hidden');
            methodInput.setAttribute('name', '_method');
            adminForm.appendChild(methodInput);
        }
        methodInput.value = 'PUT';

        // Fetch and populate admin data
        const adminRow = document.querySelector(`.action-icon.edit[data-id="${adminId}"]`).closest('tr');

        document.getElementById('name').value = adminRow.querySelector('.admin-name').textContent;
        document.getElementById('email').value = adminRow.querySelector('.admin-email').textContent;

        const roleElement = adminRow.querySelector('.admin-role');
        document.getElementById('role').value = roleElement.textContent.toLowerCase();

        const statusElement = adminRow.querySelector('.admin-status');
        document.getElementById('status').value = statusElement.classList.contains('status-active') ? '1' : '0';

        modal.classList.add('active');
    }

    // Function to close modal
    function closeAdminModal() {
        modal.classList.remove('active');
    }

    // Event Listeners
    addAdminBtn.addEventListener('click', openAddAdminModal);

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const adminId = this.getAttribute('data-id');
            openEditAdminModal(adminId);
        });
    });

    closeModal.addEventListener('click', closeAdminModal);
    cancelButton.addEventListener('click', closeAdminModal);

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeAdminModal();
        }
    });

    // Form submission validation
    adminForm.addEventListener('submit', function(e) {
        // Additional check to ensure password is only required when adding
        if (modalTitle.textContent === 'Add New Admin' && !passwordInput.value.trim()) {
            passwordInput.setCustomValidity('Password is required');
            passwordInput.reportValidity();
            e.preventDefault();
            return;
        }

        // Clear any previous custom validity
        passwordInput.setCustomValidity('');
    });
});
       </script>
</body>
</html>
@endsection
