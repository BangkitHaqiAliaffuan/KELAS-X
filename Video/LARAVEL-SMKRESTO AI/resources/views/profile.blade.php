@extends('front')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">Profil Saya</h2>
                    <p class="text-muted mb-0">Kelola informasi akun Anda</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="mb-4">
                        @php
                            $avatarType = $pelanggan->avatar_type ?? 'initial';
                            $email = session('idpelanggan')['email'];
                            $name = $pelanggan->pelanggan;
                            $initial = strtoupper(substr($name, 0, 1));
                            $colors = ['#FF6B35', '#2EC4B6', '#FDCA40', '#2196F3', '#9C27B0'];
                            $colorIndex = ord($initial) % count($colors);
                            $bgColor = $colors[$colorIndex];
                        @endphp

                        @if($avatarType == 'image' && $pelanggan->avatar_data)
                            <img src="data:image/png;base64,{{ $pelanggan->avatar_data }}" alt="Foto Profil" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @elseif($avatarType == 'gravatar')
                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($email))) }}?s=150&d=mp" alt="Gravatar" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px; font-size: 60px; background-color: {{ $bgColor }};">
                                {{ $initial }}
                            </div>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-1">{{ $pelanggan->pelanggan }}</h5>
                    <p class="text-muted mb-3">{{ session('idpelanggan')['email'] }}</p>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFotoModal">
                            <i class="fas fa-camera me-2"></i> Ganti Foto Profil
                        </button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Telepon</small>
                                <span class="fw-medium">{{ $pelanggan->telp }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span class="fw-medium">{{ $pelanggan->email }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Alamat</small>
                                <span class="fw-medium">{{ $pelanggan->alamat }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Edit Profil</h5>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ url('profile/update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pelanggan" class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control" id="pelanggan" name="pelanggan" value="{{ $pelanggan->pelanggan }}" required>
                                @error('pelanggan')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telp" class="form-label fw-semibold">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">+62</span>
                                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $pelanggan->telp }}" required>
                                </div>
                                @error('telp')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control bg-light" id="email" name="email" value="{{ $pelanggan->email }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jeniskelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                                <select class="form-select" id="jeniskelamin" name="jeniskelamin" required>
                                    <option value="L" {{ $pelanggan->jeniskelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $pelanggan->jeniskelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jeniskelamin')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $pelanggan->alamat }}</textarea>
                                @error('alamat')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-semibold">Password Baru <span class="text-muted">(Kosongkan jika tidak ingin mengubah)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Riwayat Pesanan Terakhir</h5>

                    @if(isset($orders) && count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders->take(3) as $order)
                                        <tr>
                                            <td>#{{ $order->idorder }}</td>
                                            <td>{{ date('d M Y', strtotime($order->tglorder)) }}</td>
                                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                            <td>
                                                @if($order->status == 1)
                                                    <span class="badge bg-warning">Belum Dibayar</span>
                                                @elseif($order->status == 2)
                                                    <span class="badge bg-success">Sudah Dibayar</span>
                                                @elseif($order->status == 3)
                                                    <span class="badge bg-info">Sedang Diproses</span>
                                                @elseif($order->status == 4)
                                                    <span class="badge bg-primary">Siap Diambil</span>
                                                @elseif($order->status == 5)
                                                    <span class="badge bg-secondary">Selesai</span>
                                                @else
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('order-detail/' . $order->idorder) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ url('order-history') }}" class="btn btn-outline">
                                <i class="fas fa-history me-2"></i> Lihat Semua Riwayat
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-shopping-bag text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="mb-2">Belum Ada Pesanan</h6>
                            <p class="text-muted mb-3">Anda belum memiliki riwayat pesanan.</p>
                            <a href="{{ url('menu') }}" class="btn btn-primary">
                                <i class="fas fa-utensils me-2"></i> Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Foto -->
<div class="modal fade" id="uploadFotoModal" tabindex="-1" aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFotoModalLabel">Ganti Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('profile/update-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-preview mx-auto mb-3" style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; border: 3px solid var(--primary); position: relative;">
                            <div id="imagePreview" style="width: 100%; height: 100%; background-size: cover; background-position: center;">
                                @if($avatarType == 'image' && $pelanggan->avatar_data)
                                    <img src="data:image/png;base64,{{ $pelanggan->avatar_data }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @elseif($avatarType == 'gravatar')
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($email))) }}?s=150&d=mp" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: {{ $bgColor }}; color: white; font-size: 60px;">
                                        {{ $initial }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">Pilih Foto Baru</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                }

                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
