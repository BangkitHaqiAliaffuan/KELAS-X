<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard - Ayam Goreng JOSS</title>
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

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background-color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .logo-text span {
            color: var(--primary-color);
        }

        .sidebar-menu {
            padding: 20px 0;
            overflow-y: auto;
            height: calc(100vh - 80px);
        }

        .menu-category {
            padding: 0 20px;
            margin-bottom: 10px;
            color: #888;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu-items {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--text-dark);
            transition: var(--hover-transition);
            border-left: 3px solid transparent;
            gap: 10px;
        }

        .menu-link:hover {
            background-color: rgba(255, 107, 0, 0.05);
            color: var(--primary-color);
        }

        .menu-link.active {
            background-color: rgba(255, 107, 0, 0.1);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .menu-text {
            flex: 1;
        }

        .menu-badge {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            /* margin-left: 280px; */
            transition: all 0.3s ease;
        }

        .admin-header {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            display: none;
        }

        .header-search {
            flex: 1;
            max-width: 400px;
            margin: 0 20px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--hover-transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .action-button {
            background: none;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--hover-transition);
            position: relative;
        }

        .action-button:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px;
            border-radius: 8px;
            transition: var(--hover-transition);
        }

        .user-profile:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .user-info {
            display: none;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #888;
        }

        /* Admin Content */
        .admin-content {
            padding: 30px;
        }

        .page-title {
            margin-bottom: 30px;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .user-info {
                display: none;
            }
        }

        @media (max-width: 992px) {
            .header-search {
                max-width: 300px;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 70px;
                transform: translateX(0);
            }

            .admin-sidebar.expanded {
                width: 280px;
            }

            .logo-text, .menu-text, .menu-category {
                display: none;
            }

            .admin-sidebar.expanded .logo-text,
            .admin-sidebar.expanded .menu-text,
            .admin-sidebar.expanded .menu-category {
                display: block;
            }

            .menu-link {
                justify-content: center;
                padding: 12px;
            }

            .admin-sidebar.expanded .menu-link {
                justify-content: flex-start;
                padding: 12px 20px;
            }

            .admin-main {
                margin-left: 70px;
            }

            .toggle-sidebar {
                display: block;
            }

            .header-search {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .admin-content {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .action-button {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }

        /* User Dropdown Menu */
        .user-dropdown {
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 200px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
        }

        .dropdown-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .dropdown-email {
            font-size: 0.8rem;
            color: #666;
        }

        .dropdown-items {
            list-style: none;
        }

        .dropdown-item {
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .dropdown-item:hover {
            background-color: #f9f9f9;
        }

        .dropdown-icon {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            color: #666;
        }

        .dropdown-text {
            font-size: 0.9rem;
        }

        .dropdown-divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 5px 0;
        }

        .dropdown-logout {
            color: var(--danger-color);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                <div class="logo-icon">
                    <i class="fas fa-drumstick-bite"></i>
                </div>
                <div class="logo-text">Ayam Goreng <span>JOSS</span></div>
            </a>
        </div>
        <div class="sidebar-menu">
            <div class="menu-category">Main</div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-tachometer-alt"></i></div>
                        <div class="menu-text">Dashboard</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.orders') }}" class="menu-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-shopping-bag"></i></div>
                        <div class="menu-text">Orders</div>
                        <div class="menu-badge">8</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.menus.showmenus') }}" class="menu-link {{ request()->routeIs('admin.menus.showmenus*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-utensils"></i></div>
                        <div class="menu-text">Menus</div>
                    </a>
                </li>
                {{-- <li class="menu-item">
                    <a href="{{ route('admin.categories') }}" class="menu-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-tags"></i></div>
                        <div class="menu-text">Categories</div>
                    </a>
                </li> --}}
            </ul>
            <div class="menu-category">Users</div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ route('admin.users') }}" class="menu-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-users"></i></div>
                        <div class="menu-text">Customers</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.admins') }}" class="menu-link {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-user-shield"></i></div>
                        <div class="menu-text">Staff</div>
                    </a>
                </li>
            </ul>
            <div class="menu-category">Communication</div>
            <ul class="menu-items">
                <li class="menu-item">
                    <a href="{{ route('admin.messages') }}" class="menu-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-envelope"></i></div>
                        <div class="menu-text">Messages</div>
                        <div class="menu-badge">5</div>
                    </a>
                </li>
                {{-- <li class="menu-item">
                    <a href="{{ route('admin.reviews') }}" class="menu-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-star"></i></div>
                        <div class="menu-text">Reviews</div>
                    </a>
                </li> --}}
            </ul>
            <div class="menu-category">Settings</div>
            <ul class="menu-items">
                {{-- <li class="menu-item">
                    <a href="{{ route('admin.settings') }}" class="menu-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-cog"></i></div>
                        <div class="menu-text">General</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.profile') }}" class="menu-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                        <div class="menu-icon"><i class="fas fa-user-cog"></i></div>
                        <div class="menu-text">Profile</div>
                    </a>
                </li> --}}
                <li class="menu-item">
                    <a href="{{ url('admin/logout') }}" class="menu-link">
                        <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
                        <div class="menu-text">Logout</div>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-search">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search...">
            </div>
            <div class="header-actions">
                <button class="action-button">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                <button class="action-button">
                    <i class="fas fa-envelope"></i>
                    <span class="notification-badge">5</span>
                </button>
                <div class="user-profile" id="userProfile">
                    <div class="user-avatar">
                        {{ Str::upper(substr(session('admin_name'), 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ session('admin_name') }}</div>
                        <div class="user-role">{{ session('admin_role') }}</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- User Dropdown Menu -->
        <div class="user-dropdown" id="userDropdown">
            <div class="dropdown-header">
                <div class="dropdown-name">{{ session('admin_name') }}</div>
                <div class="dropdown-email">{{ session('admin_email') }}</div>
            </div>
            <ul class="dropdown-items">
                <li class="dropdown-item">
                    <div class="dropdown-icon"><i class="fas fa-user"></i></div>
                    <div class="dropdown-text">My Profile</div>
                </li>
                <li class="dropdown-item">
                    <div class="dropdown-icon"><i class="fas fa-cog"></i></div>
                    <div class="dropdown-text">Settings</div>
                </li>
                <div class="dropdown-divider"></div>
                <li class="dropdown-item dropdown-logout">
                    <div class="dropdown-icon"><i class="fas fa-sign-out-alt"></i></div>
                    <div class="dropdown-text">Logout</div>
                </li>
            </ul>
        </div>

        <!-- Page Content -->
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Sidebar
            const toggleSidebar = document.querySelector('.toggle-sidebar');
            const sidebar = document.querySelector('.admin-sidebar');
            const mainContent = document.querySelector('.admin-main');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
            });

            // User Dropdown
            const userProfile = document.getElementById('userProfile');
            const userDropdown = document.getElementById('userDropdown');

            userProfile.addEventListener('click', function() {
                userDropdown.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userProfile.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('active');
                }
            });

            // Responsive adjustments
            function checkWidth() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('expanded');
                }
            }

            window.addEventListener('resize', checkWidth);
            checkWidth();

            // Active menu item based on current page
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.menu-link');

            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href)) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>

