@extends('admin.layouts.app')

@section('title', 'Edit Game - Epic Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">
            <i class="fas fa-gamepad me-2"></i>Edit Game
        </h2>
        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Games
        </a>
    </div>

    <div class="card border-0 shadow-lg">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0">Game Information</h5>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card bg-white shadow-sm mb-4">
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">Game Title</label>
                                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">Game Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="6" required>{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="price" class="form-label fw-bold">Price (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">Rp</span>
                                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                                   id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="category_id" class="form-label fw-bold">Category</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="release_status" class="form-label fw-bold">Release Status</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="release_status" id="status_released"
                                                   value="released" {{ old('release_status', $product->release_status) == 'released' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_released">
                                                <span class="badge bg-success">Released</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="release_status" id="status_upcoming"
                                                   value="upcoming" {{ old('release_status', $product->release_status) == 'upcoming' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_upcoming">
                                                <span class="badge bg-info">Upcoming</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="release_status" id="status_early_access"
                                                   value="early_access" {{ old('release_status', $product->release_status) == 'early_access' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_early_access">
                                                <span class="badge bg-warning text-dark">Early Access</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('release_status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-white shadow-sm mb-4">
                            <div class="card-header bg-dark text-white py-2">
                                <h6 class="mb-0">Main Cover Image</h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="position-relative mb-3 main-image-container">
                                        <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->name }}"
                                             class="img-fluid rounded border-2 shadow" id="main-image-preview" style="max-height: 250px;">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-dark">Cover</span>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label for="image" class="form-label">Change Cover Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current image</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-white shadow-sm mb-4">
                    <div class="card-header bg-dark text-white py-2">
                        <h6 class="mb-0">Game Screenshots</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Upload up to 3 high-quality screenshots to showcase your game</p>

                        @if($product->productImages->count() > 0)
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Current Screenshots</h6>
                                <div class="row g-3">
                                    @foreach($product->productImages as $index => $image)
                                        <div class="col-md-4">
                                            <div class="position-relative">
                                                <img src="{{ asset($image->image_url) }}" alt="Detail image {{ $index + 1 }}"
                                                     class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                                                <div class="position-absolute top-0 end-0 m-2">
                                                    <span class="badge bg-dark">Image {{ $index + 1 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <h6 class="fw-bold mb-3">Upload New Screenshots</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body p-2">
                                        <label for="detail_image1" class="form-label">Screenshot 1</label>
                                        <input type="file" class="form-control form-control-sm @error('detail_image1') is-invalid @enderror"
                                               id="detail_image1" name="detail_image1" accept="image/*">
                                        <div class="mt-2 text-center">
                                            <img id="detail-image1-preview" class="img-thumbnail d-none"
                                                 style="height: 100px; width: 100%; object-fit: cover;">
                                        </div>
                                        @error('detail_image1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body p-2">
                                        <label for="detail_image2" class="form-label">Screenshot 2</label>
                                        <input type="file" class="form-control form-control-sm @error('detail_image2') is-invalid @enderror"
                                               id="detail_image2" name="detail_image2" accept="image/*">
                                        <div class="mt-2 text-center">
                                            <img id="detail-image2-preview" class="img-thumbnail d-none"
                                                 style="height: 100px; width: 100%; object-fit: cover;">
                                        </div>
                                        @error('detail_image2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body p-2">
                                        <label for="detail_image3" class="form-label">Screenshot 3</label>
                                        <input type="file" class="form-control form-control-sm @error('detail_image3') is-invalid @enderror"
                                               id="detail_image3" name="detail_image3" accept="image/*">
                                        <div class="mt-2 text-center">
                                            <img id="detail-image3-preview" class="img-thumbnail d-none"
                                                 style="height: 100px; width: 100%; object-fit: cover;">
                                        </div>
                                        @error('detail_image3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-text mt-3">
                            <i class="fas fa-info-circle me-1"></i> Uploading new images will replace existing ones. Leave empty to keep current images.
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-outline-secondary px-4">Reset</button>
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-1"></i> Update Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
:root {
    --epic-blue: #0078f2;
    --epic-dark: #121212;
    --epic-gray: #2a2a2a;
    --epic-light: #f5f5f5;
}

body {
    background-color: #f8f9fa;
    color: #333;
}

.btn-primary, .bg-primary {
    background-color: var(--epic-blue) !important;
    border-color: var(--epic-blue) !important;
}

.text-primary {
    color: var(--epic-blue) !important;
}

.btn-primary:hover {
    background-color: #0062c9 !important;
    border-color: #0062c9 !important;
}

.card {
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card-header {
    border-bottom: none;
}

.form-control, .form-select {
    border-radius: 6px;
    padding: 10px 15px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--epic-blue);
    box-shadow: 0 0 0 0.2rem rgba(0, 120, 242, 0.25);
}

.btn {
    border-radius: 6px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-epic {
    background-color: var(--epic-blue);
    border-color: var(--epic-blue);
    color: white;
}

.btn-epic:hover {
    background-color: #0062c9;
    border-color: #0062c9;
    color: white;
}

.main-image-container {
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.main-image-container img {
    transition: transform 0.3s ease;
}

.main-image-container:hover img {
    transform: scale(1.03);
}

.img-thumbnail {
    border-radius: 6px;
    border: 1px solid #e0e0e0;
}

/* Epic Games inspired dark mode */
.bg-dark {
    background-color: var(--epic-dark) !important;
}

.bg-light {
    background-color: var(--epic-light) !important;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Improved image preview function with animation
    function previewImage(input, previewElement) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Remove d-none class and add fade-in effect
                previewElement.classList.remove('d-none');
                previewElement.style.opacity = '0';
                previewElement.src = e.target.result;

                // Fade in animation
                setTimeout(() => {
                    previewElement.style.transition = 'opacity 0.5s ease';
                    previewElement.style.opacity = '1';
                }, 50);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Main image preview
    const mainImageInput = document.getElementById('image');
    const mainImagePreview = document.getElementById('main-image-preview');

    mainImageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mainImagePreview.src = e.target.result;

                // Add a nice scale effect
                mainImagePreview.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    mainImagePreview.style.transition = 'transform 0.5s ease';
                    mainImagePreview.style.transform = 'scale(1)';
                }, 50);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Detail images preview
    const detailImageInputs = [
        document.getElementById('detail_image1'),
        document.getElementById('detail_image2'),
        document.getElementById('detail_image3')
    ];

    const previewElements = [
        document.getElementById('detail-image1-preview'),
        document.getElementById('detail-image2-preview'),
        document.getElementById('detail-image3-preview')
    ];

    detailImageInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            previewImage(this, previewElements[index]);
        });
    });

    // Add form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
@endsection
