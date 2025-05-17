@extends('layouts.admin')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Management - Ayam Goreng JOSS</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">
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

            /* Menu Management Specific Styles */
            .menus-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .menus-filters {
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

            .admin-content {
                margin-left: 280px;
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

            .menus-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }

            .menu-card {
                background-color: white;
                border-radius: 10px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
                transition: var(--hover-transition);
            }

            .menu-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .menu-image {
                height: 180px;
                width: 100%;
                object-fit: cover;
                transition: var(--hover-transition);
            }

            .menu-card:hover .menu-image {
                transform: scale(1.05);
            }

            .menu-image-container {
                position: relative;
                overflow: hidden;
            }

            .menu-badge {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 5px 10px;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 500;
                background-color: var(--primary-color);
                color: white;
                z-index: 1;
            }

            .menu-actions {
                position: absolute;
                bottom: 10px;
                right: 10px;
                display: flex;
                gap: 5px;
                opacity: 0;
                transform: translateY(10px);
                transition: var(--hover-transition);
            }

            .menu-card:hover .menu-actions {
                opacity: 1;
                transform: translateY(0);
            }

            .menu-action {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                background-color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--text-dark);
                cursor: pointer;
                transition: var(--hover-transition);
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .menu-action:hover {
                transform: translateY(-3px);
            }

            .action-view:hover {
                background-color: var(--info-color);
                color: white;
            }

            .action-edit:hover {
                background-color: var(--warning-color);
                color: white;
            }

            .action-delete:hover {
                background-color: var(--danger-color);
                color: white;
            }

            .menu-content {
                padding: 15px;
            }

            .menu-category {
                font-size: 0.8rem;
                color: var(--primary-color);
                margin-bottom: 5px;
                font-weight: 500;
            }

            .menu-name {
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .menu-description {
                font-size: 0.9rem;
                color: #666;
                margin-bottom: 10px;
                height: 40px;
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }

            .menu-price {
                font-weight: 600;
                color: var(--primary-color);
                font-size: 1.1rem;
            }

            .menu-status {
                display: inline-block;
                padding: 3px 8px;
                border-radius: 50px;
                font-size: 0.7rem;
                font-weight: 500;
                margin-left: 10px;
            }

            .status-available {
                background-color: rgba(76, 175, 80, 0.1);
                color: var(--success-color);
            }

            .status-out-of-stock {
                background-color: rgba(244, 67, 54, 0.1);
                color: var(--danger-color);
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

            /* Menu Detail Modal */
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

            .menu-detail-image {
                width: 100%;
                height: 250px;
                object-fit: cover;
                border-radius: 8px;
                margin-bottom: 20px;
            }

            .menu-detail-header {
                margin-bottom: 20px;
            }

            .menu-detail-category {
                font-size: 0.9rem;
                color: var(--primary-color);
                margin-bottom: 5px;
                font-weight: 500;
            }

            .menu-detail-name {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 10px;
            }

            .menu-detail-price {
                font-size: 1.3rem;
                font-weight: 600;
                color: var(--primary-color);
                margin-bottom: 5px;
            }

            .menu-detail-status {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 50px;
                font-size: 0.8rem;
                font-weight: 500;
                margin-left: 10px;
            }

            .menu-detail-description {
                margin-bottom: 20px;
                line-height: 1.6;
            }

            .menu-detail-info {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                margin-bottom: 20px;
            }

            .info-item {
                background-color: #f9f9f9;
                padding: 10px;
                border-radius: 8px;
            }

            .info-label {
                font-size: 0.8rem;
                color: #888;
                margin-bottom: 5px;
            }

            .info-value {
                font-weight: 500;
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

            /* Form Modal Styles */
            .form-group {
                margin-bottom: 20px;
            }

            .form-label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: var(--text-dark);
            }

            .form-input {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                font-size: 0.95rem;
                transition: var(--hover-transition);
            }

            .form-input:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
            }

            .form-select {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                font-size: 0.95rem;
                transition: var(--hover-transition);
                background-color: white;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 15px center;
            }

            .form-select:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
            }

            .form-textarea {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                font-size: 0.95rem;
                transition: var(--hover-transition);
                min-height: 120px;
                resize: vertical;
            }

            .form-textarea:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
            }

            .form-help {
                margin-top: 5px;
                font-size: 0.85rem;
                color: #666;
            }

            .required-field::after {
                content: '*';
                color: var(--danger-color);
                margin-left: 4px;
            }

            .error-message {
                color: var(--danger-color);
                font-size: 0.85rem;
                margin-top: 5px;
            }

            .image-preview-container {
                margin-bottom: 20px;
            }

            .image-preview {
                width: 100%;
                height: 200px;
                border-radius: 8px;
                background-color: #f1f1f1;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin-bottom: 10px;
            }

            .image-preview img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-preview-placeholder {
                color: #888;
                font-size: 0.9rem;
            }

            .image-upload-button {
                display: inline-block;
                padding: 8px 15px;
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.9rem;
                cursor: pointer;
                transition: var(--hover-transition);
            }

            .image-upload-button:hover {
                background-color: var(--primary-dark);
            }

            .checkbox-group {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .checkbox-input {
                width: 18px;
                height: 18px;
                accent-color: var(--primary-color);
            }

            .checkbox-label {
                font-size: 0.95rem;
                color: var(--text-dark);
            }

            /* Responsive */
            @media (max-width: 992px) {
                .menus-grid {
                    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                }
            }

            @media (max-width: 768px) {
                .menus-filters {
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

                .menu-detail-info {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 576px) {
                .menus-header {
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

            /* CSS sama seperti kode asli Anda, tidak diubah */
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

            /* Styles lainnya sama seperti kode asli Anda */
        </style>
    </head>

    <body>
        <div class="admin-content">
            <div class="menus-header">
                <h1 class="page-title">Menu Management</h1>
                <button class="filter-button" id="addMenuBtn">
                    <i class="fas fa-plus"></i> Add New Menu
                </button>
            </div>

            <div class="menus-filters">
                <div class="filter-group">
                    <label class="filter-label">Category:</label>
                    <select class="filter-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status:</label>
                    <select class="filter-select">
                        <option value="">All Status</option>
                        <option value="available">Available</option>
                        <option value="out-of-stock">Out of Stock</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Search:</label>
                    <input type="text" class="filter-input" placeholder="Menu name...">
                </div>
                <button class="filter-button">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button class="reset-button">Reset</button>
            </div>

            <div class="menus-grid">
                @if ($menus->isEmpty())
                    <p>Tidak ada menu ditemukan.</p>
                @else
                    @foreach ($menus as $menu)
                        <div class="menu-card">
                            <div class="menu-image-container">
                                <img src="{{ asset($menu->image) }}" alt="{{ $menu->name }}" class="menu-image">
                                <div class="menu-actions">
                                    <div class="menu-action action-view" data-menu="{{ $menu->id }}"><i
                                            class="fas fa-eye"></i></div>
                                    <div class="menu-action action-edit" data-menu="{{ $menu->id }}"><i
                                            class="fas fa-edit"></i></div>
                                    <div class="menu-action action-delete" data-menu="{{ $menu->id }}"><i
                                            class="fas fa-trash"></i></div>
                                </div>
                            </div>
                            <div class="menu-content">
                                <div class="menu-category">{{ $menu->category->name ?? 'N/A' }}</div>
                                <div class="menu-name">{{ $menu->name }}</div>
                                <div class="menu-description">{{ Str::limit($menu->description, 50) }}</div>
                                <div class="menu-price">
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    <span class="menu-status status-available">Available</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="pagination">
                <div class="pagination-info">
                    Showing {{ $menus->firstItem() }} to {{ $menus->lastItem() }} of {{ $menus->total() }} entries
                </div>
                <div class="pagination-controls">
                    @if ($menus->currentPage() > 1)
                        <a href="{{ $menus->previousPageUrl() }}" class="pagination-button">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @else
                        <span class="pagination-button disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @endif

                    @php
                        $currentPage = $menus->currentPage();
                        $totalPages = $menus->lastPage();
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
                            <a href="{{ $menus->url($page) }}" class="pagination-button">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($menus->currentPage() < $menus->lastPage())
                        <a href="{{ $menus->nextPageUrl() }}" class="pagination-button">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="pagination-button disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Menu Detail Modal -->
        <div class="modal" id="menuDetailModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Menu Detail</h2>
                    <button class="modal-close">×</button>
                </div>
                <div class="modal-body">
                    <img id="menuImage" src="/placeholder.svg" alt="" class="menu-detail-image">

                    <div class="menu-detail-header">
                        <div class="menu-detail-category" id="menuCategory"></div>
                        <div class="menu-detail-name" id="menuName"></div>
                        <div class="menu-detail-price">
                            <span id="menuPrice"></span>
                            <span class="menu-detail-status" id="menuStatus">Available</span>
                        </div>
                    </div>

                    <div class="menu-detail-description" id="menuDescription"></div>

                    <div class="menu-detail-info">
                        <div class="info-item">
                            <div class="info-label">Category</div>
                            <div class="info-value" id="menuCategoryInfo"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">SKU</div>
                            <div class="info-value" id="menuSku">N/A</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Created At</div>
                            <div class="info-value" id="menuCreatedAt"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value" id="menuUpdatedAt"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-button secondary" id="closeModal">Close</button>
                    <button class="modal-button primary" id="editDetailBtn">Edit Menu</button>
                </div>
            </div>
        </div>

        <!-- Menu Form Modal (Create/Edit) -->
        <div class="modal" id="menuFormModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="formTitle">Add New Menu</h2>
                    <button class="modal-close">×</button>
                </div>
                <div class="modal-body">
                    <form id="menuForm" method="POST" action="{{ route('admin.menus.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="methodField"></div>
                        <input type="hidden" id="menuId" name="id">

                        <div class="image-preview-container">
                            <div class="image-preview" id="imagePreview">
                                <div class="image-preview-placeholder">
                                    <i class="fas fa-image fa-3x"></i>
                                    <p>No image selected</p>
                                </div>
                            </div>
                            <label for="image" class="image-upload-button">
                                <i class="fas fa-upload"></i> Upload Image
                                <input type="file" id="image" name="image" style="display: none;"
                                    accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="name" class="form-label required-field">Menu Name</label>
                            <input type="text" id="name" name="name" class="form-input" required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id" class="form-label required-field">Category</label>
                            <select id="category_id" name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-textarea"></textarea>
                            @error('description')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-label required-field">Price (Rp)</label>
                            <input type="number" id="price" name="price" class="form-input" min="0"
                                step="1000" required>
                            @error('price')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="is_available" class="form-label">Status</label>
                            <div class="checkbox-group">
                                <input type="checkbox" id="is_available" name="is_available" class="checkbox-input"
                                    value="1" checked>
                                <label for="is_available" class="checkbox-label">Available</label>
                            </div>
                            @error('is_available')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="modal-button secondary" id="cancelFormBtn">Cancel</button>
                    <button class="modal-button primary" id="saveMenuBtn">Save Menu</button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const assetFunction = "{{ asset('') }}";

                function asset(path) {
                    return assetFunction + path.replace(/^\//, '');
                }
                // Menu Detail Modal
                const viewButtons = document.querySelectorAll('.action-view');
                const detailModal = document.getElementById('menuDetailModal');
                const closeDetailModal = detailModal.querySelector('.modal-close');
                const closeDetailBtn = document.getElementById('closeModal');
                const editDetailBtn = document.getElementById('editDetailBtn');

                // Menu Form Modal
                const formModal = document.getElementById('menuFormModal');
                const formTitle = document.getElementById('formTitle');
                const menuForm = document.getElementById('menuForm');
                const methodField = document.getElementById('methodField');
                const menuId = document.getElementById('menuId');
                const addMenuBtn = document.getElementById('addMenuBtn');
                const editButtons = document.querySelectorAll('.action-edit');
                const closeFormModal = formModal.querySelector('.modal-close');
                const cancelFormBtn = document.getElementById('cancelFormBtn');
                const saveMenuBtn = document.getElementById('saveMenuBtn');
                const deleteButtons = document.querySelectorAll('.action-delete');

                // View Menu Details
                viewButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const menuId = this.getAttribute('data-menu');
                        fetch(`/admin/menus/${menuId}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('menuImage').src = data.image;
                                document.getElementById('menuImage').alt = data.name;
                                document.getElementById('menuCategory').textContent = data.category;
                                document.getElementById('menuName').textContent = data.name;
                                document.getElementById('menuPrice').textContent =
                                    `Rp ${Number(data.price).toLocaleString('id-ID')}`;
                                document.getElementById('menuStatus').textContent = data.status;
                             
                                document.getElementById('menuDescription').textContent = data
                                    .description;
                                document.getElementById('menuCategoryInfo').textContent = data
                                    .category;
                                document.getElementById('menuSku').textContent = data.sku || 'N/A';
                                document.getElementById('menuCreatedAt').textContent = new Date(data
                                    .created_at).toLocaleDateString('id-ID');
                                document.getElementById('menuUpdatedAt').textContent = new Date(data
                                    .updated_at).toLocaleDateString('id-ID');

                                // Store menu ID for edit button
                                editDetailBtn.setAttribute('data-menu', menuId);

                                detailModal.classList.add('active');
                            });
                    });
                });

                // Close Detail Modal
                closeDetailModal.addEventListener('click', function() {
                    detailModal.classList.remove('active');
                });

                closeDetailBtn.addEventListener('click', function() {
                    detailModal.classList.remove('active');
                });

                detailModal.addEventListener('click', function(e) {
                    if (e.target === detailModal) {
                        detailModal.classList.remove('active');
                    }
                });

                // Edit from Detail Modal
                editDetailBtn.addEventListener('click', function() {
                    const menuId = this.getAttribute('data-menu');
                    detailModal.classList.remove('active');
                    openEditForm(menuId);
                });

                // Add New Menu
                addMenuBtn.addEventListener('click', function() {
                    openCreateForm();
                });

                // Edit Menu
                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const menuId = this.getAttribute('data-menu');
                        openEditForm(menuId);
                    });
                });

                // Delete Menu
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const menuId = this.getAttribute('data-menu');
                        if (confirm('Are you sure you want to delete this menu?')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/admin/menus/${menuId}`;
                            form.style.display = 'none';

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';

                            const method = document.createElement('input');
                            method.type = 'hidden';
                            method.name = '_method';
                            method.value = 'DELETE';

                            form.appendChild(csrfToken);
                            form.appendChild(method);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });

                // Close Form Modal
                closeFormModal.addEventListener('click', function() {
                    formModal.classList.remove('active');
                });

                cancelFormBtn.addEventListener('click', function() {
                    formModal.classList.remove('active');
                });

                formModal.addEventListener('click', function(e) {
                    if (e.target === formModal) {
                        formModal.classList.remove('active');
                    }
                });

                // Save Menu
                saveMenuBtn.addEventListener('click', function() {
                    if (menuForm.checkValidity()) {
                        menuForm.submit();
                    } else {
                        menuForm.reportValidity();
                    }
                });

                // Function to open create form
                function openCreateForm() {
                    formTitle.textContent = 'Add New Menu';
                    menuForm.reset();
                    menuId.value = '';
                    methodField.innerHTML = '';
                    menuForm.action = "{{ route('admin.menus.store') }}";

                    // Reset image preview
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.innerHTML = `
                    <div class="image-preview-placeholder">
                        <i class="fas fa-image fa-3x"></i>
                        <p>No image selected</p>
                    </div>
                `;

                    formModal.classList.add('active');
                }


                // Function to open edit form
                function openEditForm(id) {
                    formTitle.textContent = 'Edit Menu';
                    methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;
                    menuId.value = id;
                    menuForm.action = `/admin/menus/${id}`;

                    // Fetch menu data and populate form
                    fetch(`menus/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('name').value = data.name;
                            document.getElementById('category_id').value = data.category_id;
                            document.getElementById('description').value = data.description;
                            document.getElementById('price').value = data.price;
                            document.getElementById('is_available').checked = data.is_available;

                            // Update image preview
                            const imagePreview = document.getElementById('imagePreview');

                            if (data.image) {
                                imagePreview.innerHTML = `<img src="${asset(data.image)}" alt="${data.name}">`;
                            } else {
                                imagePreview.innerHTML = `
                <div class="image-preview-placeholder">
                    <i class="fas fa-image fa-3x"></i>
                    <p>No image selected</p>
                </div>
            `;
                            }

                            formModal.classList.add('active');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });

            // Preview image before upload
            function previewImage(input) {
                const preview = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>

    </html>
@endsection
