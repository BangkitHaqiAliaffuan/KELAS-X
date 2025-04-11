@extends('layouts.app')

@section('content')
<div class="friends-container">
    <h2 class="page-title">Friends</h2>

    <!-- Pesan Sukses/Error -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="search-container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="get" action="{{ route('friends.index') }}" class="search-form">
                    <input type="hidden" name="view" value="{{ $view }}">
                    <div class="search-input-group">
                        <input type="text" name="search" class="search-input" placeholder="Cari pengguna..." value="{{ request('search') }}">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Navigation Tabs -->
    <div class="filters-container">

        <div class="filters">
            <a href="{{ route('friends.index', ['view' => 'manage']) }}"
               class="filter-button {{ $view == 'manage' ? 'active' : '' }}">
                <i class="fas fa-user-friends me-2"></i> My Friends
            </a>
            <a href="{{ route('friends.index', ['view' => 'requests']) }}"
               class="filter-button {{ $view == 'requests' ? 'active' : '' }}">
                <i class="fas fa-user-clock me-2"></i> Friend Requests
                @if ($pendingCount > 0)
                    <span class="notification-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('friends.index', ['view' => 'add']) }}"
               class="filter-button {{ $view == 'add' ? 'active' : '' }}">
                <i class="fas fa-user-plus me-2"></i> Add Friend
            </a>
        </div>
    </div>

    <!-- Content Area -->
    <div class="friends-content">
        @if ($view == 'manage')
            <!-- Manage Friends -->
            @if ($friends->isNotEmpty())
                <div class="friend-grid">
                    @foreach ($friends as $friend)
                        <div class="friend-card">
                            <div class="friend-image-container">
                                @if ($friend->profile_image)
                                    <img src="{{ asset('uploads/profiles/' . $friend->profile_image) }}"
                                         alt="{{ $friend->username }}" class="friend-image">
                                @else
                                    <div class="friend-avatar" style="background-color: {{ \App\Helpers\AvatarHelper::getRandomColor($friend->username) }};">
                                        {{ \App\Helpers\AvatarHelper::getUserInitials($friend->username) }}
                                    </div>
                                @endif
                                <span class="friend-status">Friend</span>
                                <div class="card-overlay">
                                    <a href="{{ route('chat.index', ['user_id' => $friend->id]) }}"
                                       class="action-button primary">
                                        <i class="fas fa-comment me-1"></i> Message
                                    </a>
                                </div>
                            </div>
                            <div class="friend-info">
                                <h3 class="friend-name">{{ $friend->username }}</h3>
                                <div class="friend-email">{{ $friend->email }}</div>
                                <div class="friend-actions">
                                    <a href="{{ route('chat.index', ['user_id' => $friend->id]) }}"
                                       class="action-button primary">
                                        <i class="fas fa-comment me-1"></i> Message
                                    </a>
                                    <form method="post" action="{{ route('friends.action') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{ $friend->id }}">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit" class="action-button danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus teman ini?');">
                                            <i class="fas fa-user-minus me-1"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-user-friends"></i></div>
                    <h3>Anda belum memiliki teman</h3>
                    <p>Mulai tambahkan teman untuk memperluas jaringan Anda</p>
                    <a href="{{ route('friends.index', ['view' => 'add']) }}" class="action-button primary">
                        <i class="fas fa-user-plus me-2"></i> Cari Teman
                    </a>
                </div>
            @endif

        @elseif ($view == 'requests')
            <!-- Friend Requests -->
            @if ($requests->isNotEmpty())
                <div class="friend-grid">
                    @foreach ($requests as $request)
                        <div class="friend-card">
                            <div class="friend-image-container">
                                @if ($request->user->profile_image)
                                    <img src="{{ asset('uploads/profiles/' . $request->user->profile_image) }}"
                                         alt="{{ $request->user->username }}" class="friend-image">
                                @else
                                    <div class="friend-avatar" style="background-color: {{ \App\Helpers\AvatarHelper::getRandomColor($request->user->username) }};">
                                        {{ \App\Helpers\AvatarHelper::getUserInitials($request->user->username) }}
                                    </div>
                                @endif
                                <span class="friend-status pending">Pending</span>
                                <div class="card-overlay">
                                    <form method="post" action="{{ route('friends.action') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{ $request->user->id }}">
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="action-button success">
                                            <i class="fas fa-check me-1"></i> Accept
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="friend-info">
                                <h3 class="friend-name">{{ $request->user->username }}</h3>
                                <div class="friend-email">{{ $request->user->email }}</div>
                                <div class="friend-actions">
                                    <form method="post" action="{{ route('friends.action') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{ $request->user->id }}">
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="action-button success">
                                            <i class="fas fa-check me-1"></i> Accept
                                        </button>
                                    </form>
                                    <form method="post" action="{{ route('friends.action') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{ $request->user->id }}">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="action-button danger">
                                            <i class="fas fa-times me-1"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-user-clock"></i></div>
                    <h3>Tidak ada permintaan pertemanan tertunda</h3>
                    <p>Saat ini tidak ada permintaan pertemanan yang perlu ditinjau</p>
                    <a href="{{ route('friends.index', ['view' => 'add']) }}" class="action-button primary">
                        <i class="fas fa-user-plus me-2"></i> Cari Teman
                    </a>
                </div>
            @endif

            @elseif($view == 'add')
            <!-- Add Friends -->
            <div class="friend-grid">
                @if ($users->isNotEmpty())
                    @foreach ($users as $user)
                        <div class="friend-card">
                            <div class="friend-image-container">
                                @if ($user->profile_image)
                                    <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}"
                                         alt="{{ $user->username }}" class="friend-image">
                                @else
                                    <div class="friend-avatar" style="background-color: {{ \App\Helpers\AvatarHelper::getRandomColor($user->username) }};">
                                        {{ \App\Helpers\AvatarHelper::getUserInitials($user->username) }}
                                    </div>
                                @endif
                                <div class="card-overlay">
                                    <form method="post" action="{{ route('friends.action') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                        <input type="hidden" name="action" value="add">
                                        <button type="submit" class="action-button primary">
                                            <i class="fas fa-user-plus me-1"></i> Add Friend
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="friend-info">
                                <h3 class="friend-name">{{ $user->username }}</h3>
                                <div class="friend-email">{{ $user->email }}</div>
                                <div class="friend-actions">
                                    <form method="post" action="{{ route('friends.action') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                        <input type="hidden" name="action" value="add">
                                        <button type="submit" class="action-button primary">
                                            <i class="fas fa-user-plus me-1"></i> Add Friend
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-search"></i></div>
                        <h3>Tidak ada pengguna ditemukan</h3>
                        @if(request('search'))
                            <p>Tidak ada hasil untuk pencarian "{{ request('search') }}"</p>
                        @else
                            <p>Tidak ada pengguna baru yang dapat ditambahkan sebagai teman</p>
                        @endif
                    </div>
                @endif
            </div>

        @endif
    </div>
</div>

<style>
    /* Base Styles */
    /* Search Bar Styling */
.search-container {
    margin-bottom: 1.5rem;
}

.search-form {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
}

.search-input-group {
    display: flex;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.search-input-group:focus-within {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.search-input {
    flex-grow: 1;
    border: 1px solid #e0e0e0;
    border-right: none;
    padding: 12px 16px;
    font-size: 15px;
    border-radius: 8px 0 0 8px;
    transition: all 0.2s ease;
}

.search-input:focus {
    outline: none;
    border-color: #4a89dc;
}

.search-button {
    background-color: #4a89dc;
    color: white;
    border: none;
    padding: 0 20px;
    cursor: pointer;
    font-weight: 500;
    border-radius: 0 8px 8px 0;
    transition: all 0.2s ease;
}

.search-button:hover {
    background-color: #3a70c0;
}

.search-button i {
    margin-right: 6px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .search-container {
        padding: 0 15px;
    }

    .search-form {
        max-width: 100%;
    }

    .search-input {
        padding: 10px 12px;
    }

    .search-button {
        padding: 0 15px;
    }
}
    body {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background: #121212;
        color: white;
    }

    /* Container */
    .friends-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Page Title */
    .page-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 20px;
        color: white;
    }

    /* Alerts */
    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(46, 204, 113, 0.2);
        border: 1px solid rgba(46, 204, 113, 0.5);
        color: #2ecc71;
    }

    .alert-danger {
        background: rgba(231, 76, 60, 0.2);
        border: 1px solid rgba(231, 76, 60, 0.5);
        color: #e74c3c;
    }

    /* Filters */
    .filters-container {
        position: sticky;
        top: 0;
        z-index: 10;
        background: rgba(18, 18, 18, 0.95);
        backdrop-filter: blur(10px);
        padding: 15px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .filters {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-button {
        background: #2a2a2a;
        border: none;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-weight: 500;
        position: relative;
    }

    .filter-button:hover {
        background: #3a3a3a;
        transform: translateY(-2px);
    }

    .filter-button.active {
        background: #0078f2;
        box-shadow: 0 0 15px rgba(0, 120, 242, 0.4);
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #e74c3c;
        color: white;
        font-size: 12px;
        font-weight: bold;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    /* Friend Grid */
    .friend-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    /* Friend Card */
    .friend-card {
        background: #18181b;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .friend-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

    .friend-image-container {
        position: relative;
        overflow: hidden;
        height: 200px;
        background: #0f0f0f;
    }

    .friend-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .friend-card:hover .friend-image {
        transform: scale(1.05);
    }

    .friend-avatar {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        font-weight: bold;
        color: white;
        text-transform: uppercase;
    }

    .friend-status {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.85);
        color: white;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        backdrop-filter: blur(4px);
        z-index: 1;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .friend-status.pending {
        background: rgba(243, 156, 18, 0.85);
        color: white;
    }

    .friend-status.new {
        background: rgba(52, 152, 219, 0.85);
        color: white;
    }

    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .friend-card:hover .card-overlay {
        opacity: 1;
    }

    /* Friend Info */
    .friend-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .friend-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        margin-top: 0;
        color: #fff;
        line-height: 1.4;
    }

    .friend-email {
        font-size: 14px;
        color: #888;
        margin-bottom: 15px;
    }

    .friend-actions {
        margin-top: auto;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Action Buttons */
    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
    }

    .action-button.primary {
        background: #0078f2;
        color: white;
    }

    .action-button.primary:hover {
        background: #0069d9;
        transform: translateY(-2px);
    }

    .action-button.danger {
        background: #e74c3c;
        color: white;
    }

    .action-button.danger:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }

    .action-button.success {
        background: #2ecc71;
        color: white;
    }

    .action-button.success:hover {
        background: #27ae60;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 40px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        max-width: 500px;
        margin: 40px auto;
    }

    .empty-state-icon {
        font-size: 48px;
        color: #888;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 22px;
        margin-bottom: 10px;
        color: white;
    }

    .empty-state p {
        color: #888;
        margin-bottom: 25px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .friend-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }

        .friend-image-container {
            height: 180px;
        }

        .friend-info {
            padding: 15px;
        }

        .friend-name {
            font-size: 16px;
        }

        .action-button {
            padding: 6px 12px;
            font-size: 13px;
        }
    }

    @media (max-width: 480px) {
        .friend-grid {
            grid-template-columns: 1fr;
        }

        .filters {
            justify-content: center;
        }

        .friend-actions {
            flex-direction: column;
        }

        .action-button {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect for friend cards
        const friendCards = document.querySelectorAll('.friend-card');

        friendCards.forEach(card => {
            // Add subtle animation when cards enter viewport
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, Math.random() * 300);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            }
        });

        // Highlight notification badges with pulse animation
        const badges = document.querySelectorAll('.notification-badge');
        badges.forEach(badge => {
            badge.style.animation = 'pulse 2s infinite';
        });

        // Add keyframe animation for pulse effect
        if (!document.getElementById('pulse-animation')) {
            const style = document.createElement('style');
            style.id = 'pulse-animation';
            style.textContent = `
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.1); }
                    100% { transform: scale(1); }
                }
            `;
            document.head.appendChild(style);
        }
    });
</script>
@endsection
