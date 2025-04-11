@extends('layouts.admin')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Users Management - Ayam Goreng JOSS</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">
        <!-- Inline styles remain unchanged -->
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

            /* Sidebar styles are the same as in dashboard.blade.php */
            /* Main Content styles are the same as in dashboard.blade.php */

            /* Users Page Specific Styles */
            .users-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .users-filters {
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
                width: 200px;
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

            .users-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }

            .user-card {
                background-color: white;
                border-radius: 10px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
                transition: var(--hover-transition);
            }

            .user-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .user-header {
                background-color: var(--primary-light);
                height: 80px;
                position: relative;
            }

            .user-avatar {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background-color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                font-weight: 600;
                color: var(--primary-color);
                position: absolute;
                bottom: -40px;
                left: 20px;
                border: 4px solid white;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .user-avatar img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
            }

            .user-status {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 5px 10px;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 500;
                background-color: white;
            }

            .status-active {
                color: var(--success-color);
            }

            .status-inactive {
                color: var(--danger-color);
            }

            .user-body {
                padding: 50px 20px 20px;
            }

            .user-name {
                font-size: 1.2rem;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .user-role {
                color: #888;
                font-size: 0.9rem;
                margin-bottom: 15px;
            }

            .user-info {
                margin-bottom: 15px;
            }

            .info-item {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 8px;
                font-size: 0.9rem;
            }

            .info-icon {
                color: var(--primary-color);
                width: 16px;
                text-align: center;
            }

            .user-actions {
                display: flex;
                gap: 10px;
            }

            .user-action {
                flex: 1;
                padding: 8px;
                border-radius: 6px;
                font-size: 0.9rem;
                font-weight: 500;
                text-align: center;
                cursor: pointer;
                transition: var(--hover-transition);
            }

            .action-view {
                background-color: rgba(33, 150, 243, 0.1);
                color: var(--info-color);
            }

            .action-view:hover {
                background-color: var(--info-color);
                color: white;
            }

            .action-edit {
                background-color: rgba(255, 152, 0, 0.1);
                color: var(--warning-color);
            }

            .action-edit:hover {
                background-color: var(--warning-color);
                color: white;
            }

            .action-delete {
                background-color: rgba(244, 67, 54, 0.1);
                color: var(--danger-color);
            }

            .action-delete:hover {
                background-color: var(--danger-color);
                color: white;
            }

            .pagination {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px;
                background-color: white;
                border-radius: 10px;
                box-shadow: var(--card-shadow);
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

            /* User Detail Modal */
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

            .user-profile-header {
                display: flex;
                align-items: center;
                gap: 20px;
                margin-bottom: 20px;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background-color: var(--primary-light);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                font-weight: 600;
                color: white;
            }

            .profile-avatar img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
            }

            .profile-info {
                flex: 1;
            }

            .profile-name {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 5px;
            }

            .profile-role {
                color: #888;
                margin-bottom: 10px;
            }

            .profile-status {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 500;
            }

            .user-details {
                margin-bottom: 20px;
            }

            .detail-group {
                margin-bottom: 15px;
            }

            .detail-label {
                font-size: 0.9rem;
                color: #888;
                margin-bottom: 5px;
            }

            .detail-value {
                font-weight: 500;
            }

            .user-stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
                margin-bottom: 20px;
            }

            .stat-card {
                background-color: #f9f9f9;
                border-radius: 8px;
                padding: 15px;
                text-align: center;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--primary-color);
                margin-bottom: 5px;
            }

            .stat-label {
                font-size: 0.8rem;
                color: #888;
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
                .users-grid {
                    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                }
            }

            @media (max-width: 768px) {
                .users-filters {
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

                .user-stats {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 576px) {
                .users-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 10px;
                }

                .pagination {
                    flex-direction: column;
                    gap: 10px;
                    align-items: flex-start;
                }

                .user-stats {
                    grid-template-columns: 1fr;
                }
            }

            .admin-content {
                margin-left: 280px;
            }
        </style>

    </head>

    <body>
        <div class="admin-content">
            <div class="users-header">
                <h1 class="page-title">Users Management</h1>
                <button class="filter-button">
                    <i class="fas fa-plus"></i> Add New User
                </button>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.users') }}" class="users-filters">
                <div class="filter-group">
                    <label class="filter-label">Role:</label>
                    <select class="filter-select" name="role">
                        <option value="" {{ request('role') == '' ? 'selected' : '' }}>All Roles</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status:</label>
                    <select class="filter-select" name="status">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Search:</label>
                    <input type="text" class="filter-input" name="search" placeholder="Name, email or phone..."
                        value="{{ request('search') }}">
                </div>
                <button type="submit" class="filter-button">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('admin.users') }}" class="reset-button">Reset</a>
            </form>

            <!-- Users Grid -->
            <div class="users-grid">
                @foreach ($users as $user)
                    <div class="user-card">
                        <div class="user-header">
                            <div class="user-avatar">
                                @if ($user->gambar)
                                    <img src="{{ asset('gambar/' . $user->gambar) }}" alt="{{ $user->name }}">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="user-status {{ $user->banned == 1 ? 'status-inactive' : 'status-active' }}">
                                {{ $user->banned == 1 ? 'Banned' : 'Active' }}
                            </div>
                        </div>
                        <div class="user-body">
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-info">
                                <div class="info-item">
                                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                                    <div>{{ $user->email }}</div>
                                </div>
                                @if ($user->phone)
                                    <div class="info-item">
                                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                                        <div>{{ $user->phone }}</div>
                                    </div>
                                @endif
                                <div class="info-item">
                                    <div class="info-icon"><i class="fas fa-calendar"></i></div>
                                    <div>Joined: {{ $user->created_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                            <div class="user-actions">
                                <div class="user-action action-view" data-user="{{ $user->id }}">View</div>
                                <div class="user-action "></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination-info">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                </div>
                <div class="pagination-controls">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <!-- User Detail Modal -->
        <div class="modal" id="userDetailModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">User Profile</h2>
                    <button class="modal-close">×</button>
                </div>
                <div class="modal-body">
                    <div class="user-profile-header">
                        <div class="profile-avatar"></div>
                        <div class="profile-info">
                            <div class="profile-name"></div>
                            <div class="profile-role"></div>
                            <div class="profile-status"></div>
                        </div>
                    </div>

                    <div class="user-stats">
                        <div class="stat-card">
                            <div class="stat-value"></div>
                            <div class="stat-label">Orders</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"></div>
                            <div class="stat-label">Total Spent</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"></div>
                            <div class="stat-label">Rating</div>
                        </div>
                    </div>

                    <div class="user-details">
                        <div class="detail-group">
                            <div class="detail-label">Email</div>
                            <div class="detail-value"></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value"></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Address</div>
                            <div class="detail-value"></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Joined Date</div>
                            <div class="detail-value"></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Last Login</div>
                            <div class="detail-value"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-button secondary" id="closeModal">Close</button>
                    <button class="modal-button primary">Edit Profile</button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const viewButtons = document.querySelectorAll('.action-view');
                const modal = document.getElementById('userDetailModal');
                const closeModal = document.querySelector('.modal-close');
                const closeModalBtn = document.getElementById('closeModal');

                viewButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.getAttribute('data-user');
                        fetch(`{{ url('/admin/users') }}/${userId}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Update avatar
                                const avatar = document.querySelector('.profile-avatar');
                                if (data.gambar) {
                                    avatar.innerHTML =
                                        `<img src="{{ asset('storage') }}/${data.gambar}" alt="${data.name}">`;
                                } else {
                                    avatar.textContent = data.name.charAt(0).toUpperCase();
                                }

                                // Update profile info
                                document.querySelector('.profile-name').textContent = data.name;
                                document.querySelector('.profile-role').textContent = data.role;
                                document.querySelector('.profile-status').textContent = data.status;
                                document.querySelector('.profile-status').className =
                                    `profile-status ${data.status.toLowerCase() === 'active' ? 'status-active' : 'status-inactive'}`;

                                // Update stats
                                document.querySelector('.user-stats .stat-value:nth-child(1)')
                                    .textContent = data.orders;
                                document.querySelector('.user-stats .stat-value:nth-child(3)')
                                    .textContent =
                                    `Rp ${Number(data.total_spent).toLocaleString('id-ID')}`;
                                document.querySelector('.user-stats .stat-value:nth-child(5)')
                                    .textContent = data.rating;

                                // Update details
                                document.querySelectorAll('.detail-value')[0].textContent = data
                                    .email;
                                document.querySelectorAll('.detail-value')[1].textContent = data
                                    .phone || 'N/A';
                                document.querySelectorAll('.detail-value')[2].textContent = data
                                    .address;
                                document.querySelectorAll('.detail-value')[3].textContent =
                                    new Date(data.created_at).toLocaleDateString('en-US', {
                                        month: 'long',
                                        day: 'numeric',
                                        year: 'numeric'
                                    });
                                document.querySelectorAll('.detail-value')[4].textContent = data
                                    .last_login ? new Date(data.last_login).toLocaleString(
                                        'en-US', {
                                            month: 'long',
                                            day: 'numeric',
                                            year: 'numeric',
                                            hour: 'numeric',
                                            minute: 'numeric'
                                        }) : 'N/A';

                                modal.classList.add('active');
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });

                closeModal.addEventListener('click', function() {
                    modal.classList.remove('active');
                });

                closeModalBtn.addEventListener('click', function() {
                    modal.classList.remove('active');
                });

                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.remove('active');
                    }
                });

                function toggleUserBannedStatus(userId) {
                    fetch(`{{ url('/admin/users/toggle-banned') }}/${userId}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update user card based on banned status
                                const userCard = document.querySelector(`.user-card [data-user="${userId}"]`)
                                    .closest('.user-card');
                                const statusElement = userCard.querySelector('.user-status');

                                statusElement.textContent = data.banned == 1 ? 'Banned' : 'Active';
                                statusElement.classList.toggle('status-active', data.banned == 0);
                                statusElement.classList.toggle('status-inactive', data.banned == 1);

                                alert(data.message);
                            } else {
                                alert('Failed to update user status: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while updating user status');
                        });
                }

                // Add ban/unban button to each user card
                const userCards = document.querySelectorAll('.user-card');
                userCards.forEach(card => {
                    const actionsContainer = card.querySelector('.user-actions');
                    const userId = card.querySelector('.action-view').getAttribute('data-user');

                    const banButton = document.createElement('div');
                    banButton.className = 'user-action action-delete';
                    banButton.textContent = 'Ban';
                    banButton.setAttribute('data-user', userId);

                    banButton.addEventListener('click', function() {
                        if (confirm('Are you sure you want to toggle this user\'s banned status?')) {
                            toggleUserBannedStatus(userId);
                        }
                    });

                    actionsContainer.appendChild(banButton);
                });
            });
        </script>
    </body>

    </html>
@endsection
