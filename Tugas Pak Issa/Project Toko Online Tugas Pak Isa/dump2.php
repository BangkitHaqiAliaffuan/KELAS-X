<style>
        /* Original styles remain the same */
        :root {
            --primary-color: #007bff;
            --secondary-color: #f8f9fa;
            --accent-color: #28a745;
            --text-color: #2d3436;
            --border-radius: 15px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            color: var(--text-color);
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .order-summary {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
        }

        .section-title {
            color: var(--text-color);
            font-size: 1.5em;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-item {
            background: var(--secondary-color);
            padding: 20px;
            margin-bottom: 15px;
            border-radius: var(--border-radius);
            transition: transform 0.2s ease;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            align-items: center;
            gap: 20px;
        }

        .cart-item:hover {
            transform: translateY(-2px);
        }

        .product-info h3 {
            margin: 0 0 10px 0;
            color: var(--text-color);
            font-size: 1.1em;
        }

        .product-info p {
            margin: 5px 0;
            color: #636e72;
            font-size: 0.9em;
        }

        .quantity {
            text-align: center;
            font-weight: 500;
        }

        .price {
            text-align: right;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.1em;
        }

        .shipping-address {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
        }

        .address-content {
            background: var(--secondary-color);
            padding: 20px;
            border-radius: var(--border-radius);
            margin-top: 15px;
        }

        .total-section {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .total-price {
            font-size: 2em;
            color: var(--primary-color);
            font-weight: 700;
            margin: 20px 0;
        }

        .pay-button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius);
            cursor: pointer;
            width: 100%;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .pay-button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .thank-you-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #d4edda;
            color: #155724;
            padding: 25px 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .cart-item {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .price {
                text-align: center;
            }

            .container {
                padding: 0 15px;
            }
        }
        /* Additional styles for review form */
        .review-form-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            margin: 30px 0;
        }

        .product-review-form {
            margin-bottom: 30px;
            padding: 20px;
            background: var(--secondary-color);
            border-radius: var(--border-radius);
        }

        .rating-container {
            margin: 20px 0;
        }

        .star-rating {
            display: inline-flex;
            flex-direction: row-reverse;
            gap: 5px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            cursor: pointer;
            font-size: 25px;
            padding: 5px;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffd700;
        }

        .comment-container textarea {
            width: 100%;
            min-height: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-top: 5px;
            font-family: inherit;
        }

        .submit-review-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            margin-top: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .submit-review-btn:hover {
            background-color: #0056b3;
        }
    </style>