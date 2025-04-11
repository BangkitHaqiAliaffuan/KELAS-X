@extends('admin.layouts.app')

@section('title', 'Add New Game - Admin')

@section('additional_styles')
<style>
    :root {
        --epic-dark: #121212;
        --epic-gray: #202020;
        --epic-light-gray: #2a2a2a;
        --epic-blue: #0074e4;
        --epic-hover-blue: #0064c8;
        --epic-accent: #ffce00;
        --epic-text: #ffffff;
        --epic-secondary-text: #b3b3b3;
    }

    body {
        background-color: var(--epic-dark);
        color: var(--epic-text);
    }

    .container {
        max-width: 1200px;
        padding: 2rem 1rem;
    }

    .card {
        background-color: var(--epic-gray);
        border: none;
        border-radius: 8px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .card-body {
        padding: 2rem;
    }

    h2 {
        font-weight: 700;
        font-size: 2.25rem;
        letter-spacing: -0.5px;
        margin-bottom: 0;
        color: white;
    }

    h4 {
        font-weight: 600;
        color: white;
        margin-top: 1rem;
    }

    .form-label {
        color: var(--epic-text);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        background-color: var(--epic-light-gray);
        border: 1px solid #444;
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        background-color: var(--epic-light-gray);
        border-color: var(--epic-blue);
        color: white;
        box-shadow: 0 0 0 3px rgba(0, 116, 228, 0.25);
    }

    .form-control::placeholder {
        color: var(--epic-secondary-text);
    }

    textarea.form-control {
        min-height: 150px;
    }

    .text-muted {
        color: var(--epic-secondary-text) !important;
        font-size: 0.875rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-epic {
        background: linear-gradient(135deg, var(--epic-blue) 0%, #0088ff 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 6px;
        font-weight: 600;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 10px rgba(0, 116, 228, 0.3);
    }

    .btn-epic:hover {
        background: linear-gradient(135deg, #0068cf 0%, #0078e0 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 116, 228, 0.4);
    }

    .btn-secondary {
        background-color: var(--epic-light-gray);
        border: 1px solid #444;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #3a3a3a;
        border-color: #555;
        color: white;
    }

    .img-thumbnail {
        background-color: var(--epic-light-gray);
        border: 1px solid #444;
    }

    .invalid-feedback {
        color: #ff4d4d;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .file-upload-container {
        position: relative;
        border: 2px dashed #444;
        border-radius: 6px;
        padding: 2rem 1rem;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        margin-bottom: 1rem;
        background-color: rgba(42, 42, 42, 0.5);
    }

    .file-upload-container:hover {
        border-color: var(--epic-blue);
        background-color: rgba(0, 116, 228, 0.05);
    }

    .file-upload-container input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-icon {
        font-size: 2rem;
        color: var(--epic-secondary-text);
        margin-bottom: 1rem;
    }

    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .image-preview {
        position: relative;
        overflow: hidden;
        border-radius: 6px;
    }

    .image-preview img {
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .section-divider {
        border-top: 1px solid #444;
        margin: 2rem 0;
    }

    /* Animation for form elements */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .row > div {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .row > div:nth-child(2) {
        animation-delay: 0.1s;
    }

    .row > div:nth-child(3) {
        animation-delay: 0.2s;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Game</h2>
        <a href="{{ route('admin.products') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Games
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="name" class="form-label">Game Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter the game title" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Provide a compelling game description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label">Price (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: var(--epic-light-gray); border-color: #444; color: white;">Rp</span>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="release_status" class="form-label">Release Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="release_status" id="status_released" value="released" {{ old('release_status', 'released') == 'released' ? 'checked' : '' }} style="background-color: var(--epic-light-gray); border-color: #444;">
                                    <label class="form-check-label" for="status_released">
                                        Released
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="release_status" id="status_upcoming" value="upcoming" {{ old('release_status') == 'upcoming' ? 'checked' : '' }} style="background-color: var(--epic-light-gray); border-color: #444;">
                                    <label class="form-check-label" for="status_upcoming">
                                        Upcoming
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="release_status" id="status_early" value="early_access" {{ old('release_status') == 'early_access' ? 'checked' : '' }} style="background-color: var(--epic-light-gray); border-color: #444;">
                                    <label class="form-check-label" for="status_early">
                                        Early Access
                                    </label>
                                </div>
                            </div>
                            @error('release_status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-4">
                            <label class="form-label">Main Game Image</label>
                            <div class="file-upload-container">
                                <div class="file-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <p class="mb-1">Drag & drop your image here</p>
                                <p class="text-muted mb-0">or click to browse</p>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required>
                            </div>
                            <div id="mainImagePreviewContainer" class="image-preview" style="display: none;">
                                <img id="mainImagePreview" class="img-fluid rounded" style="width: 100%; max-height: 200px; object-fit: cover;">
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Upload the main image for the game (16:9 ratio recommended)</small>
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>

                <div class="mb-4">
                    <h4><i class="fas fa-images me-2"></i> Game Detail Images</h4>
                    <p class="text-muted">Upload up to 3 images showcasing gameplay, environment or characters</p>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="file-upload-container" style="height: 150px;">
                                <div class="file-upload-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <p class="mb-0">Detail Image 1</p>
                                <input type="file" class="form-control @error('detail_image1') is-invalid @enderror" id="detail_image1" name="detail_image1">
                            </div>
                            <div id="preview1Container" class="image-preview" style="display: none;">
                                <img id="preview1" class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                            </div>
                            @error('detail_image1')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="file-upload-container" style="height: 150px;">
                                <div class="file-upload-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <p class="mb-0">Detail Image 2</p>
                                <input type="file" class="form-control @error('detail_image2') is-invalid @enderror" id="detail_image2" name="detail_image2">
                            </div>
                            <div id="preview2Container" class="image-preview" style="display: none;">
                                <img id="preview2" class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                            </div>
                            @error('detail_image2')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="file-upload-container" style="height: 150px;">
                                <div class="file-upload-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <p class="mb-0">Detail Image 3</p>
                                <input type="file" class="form-control @error('detail_image3') is-invalid @enderror" id="detail_image3" name="detail_image3">
                            </div>
                            <div id="preview3Container" class="image-preview" style="display: none;">
                                <img id="preview3" class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                            </div>
                            @error('detail_image3')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-epic">
                        <i class="fas fa-plus-circle me-2"></i> Add Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image preview function
    function previewImage(input, previewElement, containerElement) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewElement.src = e.target.result;
                containerElement.style.display = 'block';
                input.parentNode.style.display = 'none'; // Hide the upload container
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Main image preview
    const mainImageInput = document.getElementById('image');
    const mainImagePreview = document.getElementById('mainImagePreview');
    const mainImagePreviewContainer = document.getElementById('mainImagePreviewContainer');

    mainImageInput.addEventListener('change', function() {
        previewImage(this, mainImagePreview, mainImagePreviewContainer);
    });

    // Detail images preview
    for (let i = 1; i <= 3; i++) {
        const detailInput = document.getElementById('detail_image' + i);
        const preview = document.getElementById('preview' + i);
        const previewContainer = document.getElementById('preview' + i + 'Container');

        detailInput.addEventListener('change', function() {
            previewImage(this, preview, previewContainer);
        });
    }

    // Add support for drag-and-drop file uploads
    const fileUploadContainers = document.querySelectorAll('.file-upload-container');

    fileUploadContainers.forEach(container => {
        container.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--epic-blue)';
            this.style.backgroundColor = 'rgba(0, 116, 228, 0.1)';
        });

        container.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#444';
            this.style.backgroundColor = 'rgba(42, 42, 42, 0.5)';
        });

        container.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#444';
            this.style.backgroundColor = 'rgba(42, 42, 42, 0.5)';

            const fileInput = this.querySelector('input[type="file"]');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;

                // Trigger change event to update preview
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            }
        });
    });
</script>
@endsection
