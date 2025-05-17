@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Profile - Ayam Goreng Lezat</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            body {
                background-color: #f8f8f8;
                color: #333;
            }

            .profile-section {
                position: relative;
                min-height: 100vh;
                padding: 80px 5% 100px;
                background: linear-gradient(135deg, #ffebee 0%, #fff8e1 100%);
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .profile-section::before {
                content: '';
                position: absolute;
                top: -50px;
                right: -50px;
                width: 200px;
                height: 200px;
                background: url('/api/placeholder/200/200') no-repeat;
                opacity: 0.1;
                transform: rotate(15deg);
                z-index: 0;
            }

            .profile-section::after {
                content: '';
                position: absolute;
                bottom: -50px;
                left: -50px;
                width: 200px;
                height: 200px;
                background: url('/api/placeholder/200/200') no-repeat;
                opacity: 0.1;
                transform: rotate(-15deg);
                z-index: 0;
            }

            .profile-container {
                width: 100%;
                max-width: 600px;
                background-color: white;
                border-radius: 15px;
                padding: 50px 40px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
                position: relative;
                z-index: 1;
                opacity: 0;
                transform: translateY(50px);
                transition: opacity 0.8s ease, transform 0.8s ease;
            }

            .profile-container.visible {
                opacity: 1;
                transform: translateY(0);
            }

            .profile-container::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 150px;
                height: 150px;
                background: linear-gradient(135deg, #fff3e0, #ffccbc);
                border-radius: 0 0 0 100%;
                z-index: -1;
            }

            .profile-container::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 150px;
                height: 150px;
                background: linear-gradient(135deg, #ffccbc, #fff3e0);
                border-radius: 0 100% 0 0;
                z-index: -1;
            }

            .profile-header {
                display: flex;
                align-items: center;
                margin-bottom: 40px;
                flex-direction: column;
                text-align: center;
            }

            .avatar-container {
                position: relative;
                margin-bottom: 20px;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                padding: 5px;
                background: linear-gradient(135deg, #e65100, #ff9800);
                box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
            }

            .avatar-edit {
                position: absolute;
                right: 0;
                bottom: 0;
                width: 35px;
                height: 35px;
                background-color: #e65100;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            }

            .avatar-edit:hover {
                background-color: #ff9800;
                transform: scale(1.1);
            }

            .profile-title {
                font-size: 2rem;
                color: #e65100;
                margin-bottom: 15px;
                position: relative;
                display: inline-block;
            }

            .profile-title::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 80px;
                height: 4px;
                background: linear-gradient(to right, #e65100, #ff9800);
                border-radius: 2px;
            }

            .profile-subtitle {
                font-size: 1rem;
                color: #666;
            }

            .profile-info {
                margin-bottom: 40px;
            }

            .info-group {
                display: flex;
                margin-bottom: 20px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }

            .info-group:last-child {
                border-bottom: none;
            }

            .info-label {
                width: 30%;
                font-weight: 600;
                color: #333;
                display: flex;
                align-items: center;
            }

            .info-label i {
                margin-right: 10px;
                color: #e65100;
                font-size: 1.2rem;
                width: 24px;
                text-align: center;
            }

            .info-value {
                width: 70%;
                color: #666;
            }

            .profile-actions {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin-top: 30px;
            }

            .profile-button {
                padding: 12px 25px;
                background: linear-gradient(to right, #e65100, #ff9800);
                color: white;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.4s ease;
                position: relative;
                overflow: hidden;
                z-index: 1;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .profile-button::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(to right, #ff9800, #e65100);
                transition: all 0.4s ease;
                z-index: -1;
            }

            .profile-button:hover::before {
                left: 0;
            }

            .profile-button:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(230, 81, 0, 0.2);
            }

            .profile-button.secondary {
                background: white;
                color: #e65100;
                border: 2px solid #e65100;
            }

            .profile-button.secondary::before {
                background: #f5f5f5;
            }

            .profile-button.secondary:hover {
                color: #ff9800;
                border-color: #ff9800;
            }

            .floating-chicken {
                position: absolute;
                width: 120px;
                height: 120px;
                background: url('/api/placeholder/120/120') no-repeat;
                z-index: 1;
                animation: float 6s ease-in-out infinite;
            }

            .chicken1 {
                top: 10%;
                left: 5%;
                animation-delay: 0s;
            }

            .chicken2 {
                bottom: 20%;
                right: 5%;
                animation-delay: 2s;
            }

            @keyframes float {
                0% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-20px) rotate(5deg);
                }

                100% {
                    transform: translateY(0px) rotate(0deg);
                }
            }

            .alert {
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 8px;
                display: flex;
                align-items: center;
            }

            .alert-success {
                background-color: #e8f5e9;
                color: #2e7d32;
                border-left: 4px solid #2e7d32;
            }

            .alert i {
                margin-right: 10px;
                font-size: 1.2rem;
            }

            /* Modal Styles */
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .modal-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .modal {
                background-color: white;
                border-radius: 15px;
                width: 90%;
                max-width: 500px;
                padding: 40px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
                position: relative;
                transform: translateY(30px);
                transition: all 0.4s ease;
            }

            .modal-overlay.active .modal {
                transform: translateY(0);
            }

            .modal::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100px;
                height: 100px;
                background: linear-gradient(135deg, #fff3e0, #ffccbc);
                border-radius: 0 15px 0 100%;
                z-index: -1;
            }

            .modal-header {
                text-align: center;
                margin-bottom: 30px;
            }

            .modal-title {
                font-size: 1.8rem;
                color: #e65100;
                margin-bottom: 10px;
                position: relative;
                display: inline-block;
            }

            .modal-title::after {
                content: '';
                position: absolute;
                bottom: -8px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background: linear-gradient(to right, #e65100, #ff9800);
                border-radius: 2px;
            }

            .modal-close {
                position: absolute;
                top: 15px;
                right: 15px;
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #999;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .modal-close:hover {
                color: #e65100;
                transform: rotate(90deg);
            }

            .form-group {
                margin-bottom: 25px;
                position: relative;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: #333;
                transition: all 0.3s ease;
            }

            .form-group input {
                width: 100%;
                padding: 14px 20px;
                padding-left: 45px;
                border: 2px solid #eee;
                border-radius: 8px;
                font-family: 'Poppins', sans-serif;
                font-size: 1rem;
                transition: all 0.3s ease;
                background-color: #f9f9f9;
            }

            .form-group input:focus {
                border-color: #e65100;
                outline: none;
                box-shadow: 0 0 0 3px rgba(230, 81, 0, 0.1);
                background-color: white;
            }

            .form-group input:focus+label {
                color: #e65100;
            }

            .form-icon {
                position: absolute;
                left: 15px;
                top: 48px;
                color: #e65100;
                font-size: 1.2rem;
            }

            .form-actions {
                display: flex;
                justify-content: space-between;
                margin-top: 30px;
            }

            .form-button {
                padding: 12px 25px;
                background: linear-gradient(to right, #e65100, #ff9800);
                color: white;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.4s ease;
                flex: 1;
                text-align: center;
            }

            .form-button:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
            }

            .form-button.cancel {
                background: #f5f5f5;
                color: #666;
                margin-right: 10px;
            }

            .form-button.cancel:hover {
                background: #eee;
            }

            .form-button.submit {
                background: linear-gradient(to right, #e65100, #ff9800);
                color: white;
                margin-left: 10px;
            }

            /* Avatar Upload Styles */
            .avatar-upload {
                margin-bottom: 30px;
                text-align: center;
            }

            .avatar-preview {
                width: 120px;
                height: 120px;
                position: relative;
                margin: 0 auto 20px;
                border-radius: 50%;
                padding: 5px;
                background: linear-gradient(135deg, #e65100, #ff9800);
                box-shadow: 0 5px 15px rgba(230, 81, 0, 0.2);
            }

            .avatar-preview img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
            }

            .avatar-input {
                display: none;
            }

            .avatar-label {
                display: inline-block;
                padding: 10px 20px;
                background: #f5f5f5;
                border-radius: 8px;
                color: #666;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .avatar-label:hover {
                background: #eee;
                color: #e65100;
            }

            .avatar-label i {
                margin-right: 8px;
            }

            /* Avatar Edit Modal */
            .avatar-modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .avatar-modal-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .avatar-modal {
                background-color: white;
                border-radius: 15px;
                width: 90%;
                max-width: 400px;
                padding: 30px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
                position: relative;
                transform: translateY(30px);
                transition: all 0.4s ease;
            }

            .avatar-modal-overlay.active .avatar-modal {
                transform: translateY(0);
            }

            @media screen and (max-width: 768px) {
                .profile-section {
                    padding: 40px 20px;
                }

                .profile-container {
                    padding: 40px 30px;
                }

                .floating-chicken {
                    display: none;
                }

                .info-group {
                    flex-direction: column;
                }

                .info-label, .info-value {
                    width: 100%;
                }

                .info-value {
                    margin-top: 8px;
                    padding-left: 34px;
                }

                .profile-actions {
                    flex-direction: column;
                }

                .modal {
                    padding: 30px 20px;
                }

                .form-actions {
                    flex-direction: column;
                    gap: 10px;
                }

                .form-button.cancel {
                    margin-right: 0;
                    margin-bottom: 10px;
                }

                .form-button.submit {
                    margin-left: 0;
                }
            }

            @media screen and (max-width: 480px) {
                .profile-container {
                    padding: 30px 20px;
                }

                .profile-title {
                    font-size: 1.8rem;
                }

                .profile-actions {
                    gap: 10px;
                }
            }
        </style>
    </head>

    <body>
        <section class="profile-section">
            <div class="floating-chicken chicken1"></div>
            <div class="floating-chicken chicken2"></div>
            <div class="profile-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="profile-header">
                    <div class="avatar-container">
                        <img src="{{ asset($user->gambar ?? 'gambar/user-avatar.jpg') }}" alt="User Avatar" class="profile-avatar">
                        <div class="avatar-edit" id="avatarEditBtn">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <h1 class="profile-title">{{ $user->name }}</h1>
                    <p class="profile-subtitle">Member sejak {{ $user->created_at->format('d M Y') }}</p>
                </div>

                <div class="profile-info">
                    <div class="info-group">
                        <div class="info-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i> Email
                        </div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">
                            <i class="fas fa-phone"></i> Nomor Telepon
                        </div>
                        <div class="info-value">{{ $user->phone ?? 'Belum diatur' }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i> Alamat
                        </div>
                        <div class="info-value">{{ $user->address ?? 'Belum diatur' }}</div>
                    </div>
                </div>

                <div class="profile-actions">
                    <button class="profile-button" id="editProfileBtn">
                        <i class="fas fa-edit"></i> Edit Profil
                    </button>
                    <button class="profile-button secondary" id="changePasswordBtn">
                        <i class="fas fa-lock"></i> Ubah Password
                    </button>
                </div>
            </div>
        </section>

        <!-- Modal for Edit Profile and Change Password -->
        <div class="modal-overlay" id="formModal">
            <div class="modal">
                <button class="modal-close" id="closeModal">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-header">
                    <h2 class="modal-title" id="modalTitle">Edit Profil</h2>
                </div>
                <form id="userForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Edit Profile Fields -->
                    <div id="profileFields">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <i class="fas fa-user form-icon"></i>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <i class="fas fa-envelope form-icon"></i>
                            <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <i class="fas fa-phone form-icon"></i>
                            <input type="text" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <i class="fas fa-map-marker-alt form-icon"></i>
                            <input type="text" id="address" name="address" value="{{ $user->address }}">
                        </div>
                    </div>

                    <!-- Change Password Fields -->
                    <div id="passwordFields" style="display: none;">
                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <i class="fas fa-lock form-icon"></i>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <i class="fas fa-key form-icon"></i>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <i class="fas fa-check-circle form-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="form-button cancel" id="cancelBtn">Batal</button>
                        <button type="submit" class="form-button submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Avatar Edit Modal -->
        <div class="avatar-modal-overlay" id="avatarModal">
            <div class="avatar-modal">
                <button class="modal-close" id="closeAvatarModal">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-header">
                    <h2 class="modal-title">Ubah Foto Profil</h2>
                </div>
                <form id="avatarForm" method="POST" action="{{ url('profile/update-avatar') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <img id="avatarPreview" src="{{ asset($user->gambar ?? 'gambar/user-avatar.jpg') }}" alt="Avatar Preview">
                        </div>
                        <input type="file" name="gambar" id="avatarInput" class="avatar-input" accept="image/*">
                        <label for="avatarInput" class="avatar-label">
                            <i class="fas fa-upload"></i> Pilih Foto
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="form-button cancel" id="cancelAvatarBtn">Batal</button>
                        <button type="submit" class="form-button submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Animation for profile container
                setTimeout(() => {
                    document.querySelector('.profile-container').classList.add('visible');
                }, 300);

                // Modal elements
                const modal = document.getElementById('formModal');
                const modalTitle = document.getElementById('modalTitle');
                const profileFields = document.getElementById('profileFields');
                const passwordFields = document.getElementById('passwordFields');
                const userForm = document.getElementById('userForm');

                // Avatar modal elements
                const avatarModal = document.getElementById('avatarModal');
                const avatarInput = document.getElementById('avatarInput');
                const avatarPreview = document.getElementById('avatarPreview');

                // Buttons
                const editProfileBtn = document.getElementById('editProfileBtn');
                const changePasswordBtn = document.getElementById('changePasswordBtn');
                const closeModal = document.getElementById('closeModal');
                const cancelBtn = document.getElementById('cancelBtn');
                const avatarEditBtn = document.getElementById('avatarEditBtn');
                const closeAvatarModal = document.getElementById('closeAvatarModal');
                const cancelAvatarBtn = document.getElementById('cancelAvatarBtn');

                // Edit Profile Button Click
                editProfileBtn.addEventListener('click', () => {
                    modalTitle.textContent = 'Edit Profil';
                    profileFields.style.display = 'block';
                    passwordFields.style.display = 'none';
                    userForm.action = "{{ url('profile/update') }}";
                    modal.classList.add('active');
                });

                // Change Password Button Click
                changePasswordBtn.addEventListener('click', () => {
                    modalTitle.textContent = 'Ubah Password';
                    profileFields.style.display = 'none';
                    passwordFields.style.display = 'block';
                    userForm.action = "{{ url('profile/change-password') }}";
                    modal.classList.add('active');
                });

                // Avatar Edit Button Click
                avatarEditBtn.addEventListener('click', () => {
                    avatarModal.classList.add('active');
                });

                // Avatar Input Change (Preview)
                avatarInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });

                // Close Modal Functions
                const closeModalFunction = () => {
                    modal.classList.remove('active');
                };

                const closeAvatarModalFunction = () => {
                    avatarModal.classList.remove('active');
                };

                closeModal.addEventListener('click', closeModalFunction);
                cancelBtn.addEventListener('click', closeModalFunction);
                closeAvatarModal.addEventListener('click', closeAvatarModalFunction);
                cancelAvatarBtn.addEventListener('click', closeAvatarModalFunction);

                // Close modal when clicking outside
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeModalFunction();
                    }
                });

                avatarModal.addEventListener('click', (e) => {
                    if (e.target === avatarModal) {
                        closeAvatarModalFunction();
                    }
                });
            });
        </script>
    </body>

    </html>
@endsection
