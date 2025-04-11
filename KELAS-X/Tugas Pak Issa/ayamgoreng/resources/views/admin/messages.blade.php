@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Ayam Goreng JOSS</title>
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

        /* Sidebar styles are the same as in dashboard.blade.php */
        /* Main Content styles are the same as in dashboard.blade.php */

        /* Messages Page Specific Styles */
        .messages-container {
            display: flex;
            height: calc(100vh - 180px);
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .messages-sidebar {
            width: 300px;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
        }

        .messages-search {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--hover-transition);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%23888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>');
            background-repeat: no-repeat;
            background-position: 15px center;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
        }

        .messages-filters {
            padding: 10px 15px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
        }

        .filter-tab {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .filter-tab.active {
            background-color: var(--primary-color);
            color: white;
        }

        .filter-tab:hover:not(.active) {
            background-color: #f1f1f1;
        }

        .messages-list {
            flex: 1;
            overflow-y: auto;
        }

        .message-item {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .message-item:hover {
            background-color: #f9f9f9;
        }

        .message-item.active {
            background-color: rgba(255, 107, 0, 0.05);
            border-left: 3px solid var(--primary-color);
        }

        .message-item.unread {
            background-color: rgba(33, 150, 243, 0.05);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .message-sender {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .message-time {
            font-size: 0.8rem;
            color: #888;
        }

        .message-subject {
            font-weight: 500;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-preview {
            font-size: 0.8rem;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 5px;
        }

        .message-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .badge-unread {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info-color);
        }

        .badge-important {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        .message-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .content-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .content-actions {
            display: flex;
            gap: 10px;
        }

        .content-action {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            background-color: #f1f1f1;
            cursor: pointer;
            transition: var(--hover-transition);
        }

        .content-action:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .content-body {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
        }

        .message-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .sender-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .sender-info {
            flex: 1;
        }

        .sender-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sender-email {
            font-size: 0.9rem;
            color: #666;
        }

        .message-date {
            font-size: 0.9rem;
            color: #888;
        }

        .message-subject-full {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .message-body {
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .reply-form {
            margin-top: 20px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
        }

        .reply-textarea {
            width: 100%;
            min-height: 150px;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 15px;
            resize: vertical;
        }

        .reply-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
        }

        .reply-button {
            padding: 10px 20px;
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
            float: right;
        }

        .reply-button:hover {
            background-color: var(--primary-dark);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 20px;
            text-align: center;
            color: #888;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #ddd;
        }

        .empty-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-description {
            font-size: 0.9rem;
            max-width: 300px;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .messages-container {
                flex-direction: column;
                height: auto;
            }

            .messages-sidebar {
                width: 100%;
                height: 300px;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }

            .message-content {
                height: 500px;
            }
        }

        @media (max-width: 768px) {
            .messages-filters {
                overflow-x: auto;
                padding-bottom: 15px;
            }

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .content-actions {
                align-self: flex-end;
            }
        }

        @media (max-width: 576px) {
            .message-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .sender-avatar {
                margin-right: 0;
            }

            .message-date {
                align-self: flex-start;
            }
        }
        .admin-content{
        margin-left: 280px;
    }
    </style>
</head>
<body>
    <!-- Sidebar (same as in dashboard.blade.php) -->
    <!-- Main Content Header (same as in dashboard.blade.php) -->

    <div class="admin-content">
        <h1 class="page-title">Messages</h1>

        <div class="messages-container">
            <div class="messages-sidebar">
                <div class="messages-search">
                    <input type="text" class="search-input" placeholder="Search messages...">
                </div>
                <div class="messages-filters">
                    <div class="filter-tab active">All</div>
                    <div class="filter-tab">Unread</div>
                    <div class="filter-tab">Important</div>
                    <div class="filter-tab">Archived</div>
                </div>
                <div class="messages-list">
                    @if(count($messages) > 0)
                        @foreach($messages as $message)
                            <div class="message-item {{ $activeMessage && $activeMessage->id == $message->id ? 'active' : '' }} {{ !in_array($message->id, session('read_messages', [])) ? 'unread' : '' }}">
                                <a href="{{ route('admin.messages.show', $message->id) }}">
                                    <div class="message-header">
                                        <div class="message-sender">{{ $message->name }}</div>
                                        <div class="message-time">{{ $message->created_at->diffForHumans() }}</div>
                                    </div>
                                    <div class="message-subject">{{ $message->subject }}</div>
                                    <div class="message-preview">{{ Str::limit($message->message, 100) }}</div>
                                    <div class="message-status">
                                        @if(!in_array($message->id, session('read_messages', [])))
                                            <div class="message-badge badge-unread">Unread</div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                            <div class="empty-title">No messages</div>
                            <div class="empty-description">You don't have any messages yet.</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="message-content">
                @if($activeMessage)
                    <div class="content-header">
                        <div class="content-title">Message Details</div>
                        <div class="content-actions">
                            <div class="content-action" title="Reply"><i class="fas fa-reply"></i></div>
                            <form action="{{ route('admin.messages.delete', $activeMessage->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="content-action" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="content-body">
                        <div class="message-info">
                            <div class="sender-avatar">{{ strtoupper(substr($activeMessage->name, 0, 1)) }}{{ strtoupper(substr($activeMessage->name, strpos($activeMessage->name, ' ') + 1, 1)) }}</div>
                            <div class="sender-info">
                                <div class="sender-name">{{ $activeMessage->name }}</div>
                                <div class="sender-email">{{ $activeMessage->email }}</div>
                                @if($activeMessage->phone)
                                    <div class="sender-phone">{{ $activeMessage->phone }}</div>
                                @endif
                            </div>
                            <div class="message-date">{{ $activeMessage->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="message-subject-full">{{ $activeMessage->subject }}</div>
                        <div class="message-body">
                            {!! nl2br(e($activeMessage->message)) !!}
                        </div>

                        @if(session('replyForm'))
                            <div class="reply-form">
                                <form action="{{ route('admin.messages.reply', $activeMessage->id) }}" method="POST">
                                    @csrf
                                    <textarea name="reply" class="reply-textarea" placeholder="Type your reply here..." required>{{ old('reply') }}</textarea>
                                    <button type="submit" class="reply-button"><i class="fas fa-paper-plane"></i> Send Reply</button>
                                </form>
                            </div>
                        @endif

                        @if(session('replySuccess'))
                            <div class="alert alert-success" style="margin-top: 20px; padding: 15px; border-radius: 5px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                                {{ session('replySuccess') }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-envelope-open"></i></div>
                        <div class="empty-title">No message selected</div>
                        <div class="empty-description">Select a message from the list to view its contents.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Message item click
            const messageItems = document.querySelectorAll('.message-item');

            messageItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    messageItems.forEach(i => i.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Remove unread class if present
                    if (this.classList.contains('unread')) {
                        this.classList.remove('unread');
                        const unreadBadge = this.querySelector('.badge-unread');
                        if (unreadBadge) {
                            unreadBadge.remove();
                        }
                    }

                    // Here you would typically load the message content
                    // For now, we'll just keep the current content
                });
            });

            // Filter tabs
            const filterTabs = document.querySelectorAll('.filter-tab');

            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    filterTabs.forEach(t => t.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Here you would typically filter the messages
                    // For now, we'll just keep all messages visible
                });
            });

            // Reply button functionality
            const replyButton = document.querySelector('.content-action i.fa-reply');
            if (replyButton) {
                replyButton.addEventListener('click', function() {
                    window.location.href = "{{ $activeMessage ? route('admin.messages.showReplyForm', $activeMessage->id) : '#' }}";
                });
            }
        });
    </script>
</body>
</html>
@endsection

