<style>
    .profile-container {
        max-width: 1000px;
        margin: 30px auto;
        background: #18181b;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .profile-header {
        padding: 25px 30px;
        border-bottom: 1px solid #2a2a2a;
    }

    .profile-header h1 {
        margin: 0;
        color: white;
        font-size: 24px;
    }

    .alert {
        margin-top: 15px;
        padding: 12px 15px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(0, 200, 83, 0.2);
        color: #00c853;
        border: 1px solid rgba(0, 200, 83, 0.3);
    }

    .alert-error {
        background: rgba(255, 77, 77, 0.2);
        color: #ff4d4d;
        border: 1px solid rgba(255, 77, 77, 0.3);
    }

    .profile-content {
        display: flex;
        flex-wrap: wrap;
        padding: 30px;
        position: relative;
    }

    .profile-sidebar {
        width: 100%;
        text-align: center;
    }

    .user-description {
        margin: 20px auto;
        text-align: left;
        background: #1e1e22;
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        border-left: 3px solid #0078f2;
    }

    .user-description h3 {
        color: #0078f2;
        margin-top: 0;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .user-description p {
        color: #ddd;
        line-height: 1.6;
        margin: 0;
    }

    .profile-details {
        border-left: 3px solid #0078f2;
        margin: 20px 0;
        text-align: left;
        background: #1e1e22;
        padding: 15px;
        border-radius: 8px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .profile-details p {
        margin: 8px 0;
        color: #ddd;
    }

    .profile-details strong {
        color: #0078f2;
        display: inline-block;
        width: 80px;
    }

    /* Favorite Games Styles */
    .favorite-games {
        width: 100%;
        margin-top: 40px;
        padding: 20px;
        background: #1e1e22;
        border-radius: 8px;
        border-left: 3px solid #0078f2;
    }

    .favorite-games h3 {
        color: #0078f2;
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 20px;
        text-align: center;
    }

    .games-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
    }

    .game-card {
        background: #232327;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .game-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .game-image {
        width: 100%;
        height: 150px;
        overflow: hidden;
        position: relative;
    }

    .game-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .game-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #2a2a2a;
        color: #888;
        font-size: 14px;
    }

    .game-title {
        padding: 10px;
        color: white;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-form-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 600px;
        z-index: 1000;
        background: #18181b;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.4);
        max-height: 90vh;
        overflow-y: auto;
    }

    .profile-image-container {
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
        position: relative;
        border-radius: 50%;
        overflow: hidden;
        background: #2a2a2a;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0078f2;
        color: white;
        font-size: 64px;
        font-weight: bold;
    }

    .profile-info {
        text-align: center;
        padding: 0 15px;
    }

    .profile-info h2 {
        margin: 0 0 5px;
        color: white;
    }

    .profile-info .email {
        color: #0078f2;
        margin: 0 0 15px;
    }

    .profile-info .member-since {
        color: #888;
        font-size: 13px;
        margin: 0;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #2a2a2a;
        padding-bottom: 15px;
    }

    .form-header h3 {
        margin: 0;
        color: white;
        font-size: 20px;
    }

    .close-button {
        background: none;
        border: none;
        color: #888;
        font-size: 24px;
        cursor: pointer;
        transition: color 0.2s;
    }

    .close-button:hover {
        color: white;
    }

    .profile-form {
        background: #1e1e22;
        padding: 25px;
        border-radius: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #aaa;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        background: #2a2a2a;
        border: 1px solid #3a3a3a;
        border-radius: 6px;
        color: white;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #0078f2;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 120, 242, 0.3);
    }

    .form-group small {
        display: block;
        margin-top: 6px;
        color: #888;
        font-size: 12px;
    }

    .form-group input[disabled] {
        background: #232327;
        color: #888;
    }

    .form-group input[type="file"] {
        padding: 10px;
    }

    .update-button {
        background: #0078f2;
        color: white;
        border: none;
        padding: 14px 20px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 300px;
        margin: 20px auto 0;
    }

    .update-button:hover {
        background: #0066cc;
        transform: translateY(-2px);
    }

    .cancel-button {
        background: #2a2a2a;
        color: #ddd;
        border: none;
        padding: 14px 20px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 10px;
    }

    .cancel-button:hover {
        background: #353535;
    }

    /* Overlay to darken background when form is visible */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 900;
        display: none;
    }

    @media (max-width: 768px) {
        .profile-content {
            flex-direction: column;
        }

        .profile-sidebar {
            width: 100%;
            margin-bottom: 30px;
        }

        .profile-form-container {
            width: 95%;
        }

        .games-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
</style>
