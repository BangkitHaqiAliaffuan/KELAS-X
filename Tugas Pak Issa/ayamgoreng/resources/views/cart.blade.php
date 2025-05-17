@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Ayam Goreng Lezat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
            overflow-x: hidden;
        }

        body::-webkit-scrollbar{
            display: none;
        }


        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
        }

        /* Cart Section */
        .cart-section {
            padding: 120px 5% 60px;
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #333;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            height: 4px;
            width: 60px;
            background-color: #e65100;
            bottom: -10px;
            left: 0;
        }

        .cart-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        .cart-empty {
            text-align: center;
            padding: 50px 0;
        }

        .cart-empty h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #666;
        }

        .cart-empty .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #e65100;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .cart-empty .btn:hover {
            background-color: #d84315;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            display: grid;
            grid-template-columns: 100px 2fr 1fr 1fr 1fr 50px;
            gap: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }

        .cart-header div {
            text-align: center;
        }

        .cart-header div:nth-child(2) {
            text-align: left;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 2fr 1fr 1fr 1fr 50px;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-details h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .cart-item-details p {
            font-size: 0.9rem;
            color: #666;
        }

        .cart-item-price, .cart-item-subtotal {
            font-weight: 600;
            color: #e65100;
            text-align: center;
        }

        /* Updated quantity control styles for perfect horizontal alignment */
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-control form {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            font-size: 16px;
            color: #e65100;
        }

        .quantity-btn:hover {
            background-color: #e65100;
            color: white;
            border-color: #e65100;
        }

        .quantity-input {
            width: 40px;
            height: 30px;
            margin: 0 8px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-weight: 600;
            color: #333;
        }

        /* Remove number input arrows */
        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .quantity-input {
            -moz-appearance: textfield;
        }

        .remove-item {
            background: none;
            border: none;
            color: #999;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .remove-item:hover {
            color: #e65100;
        }

        .cart-summary {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .summary-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-label {
            color: #666;
        }

        .summary-value {
            font-weight: 600;
        }

        .summary-total {
            font-size: 1.2rem;
            font-weight: 700;
            color: #e65100;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .checkout-btn {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background-color: #e65100;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            background-color: #d84315;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .cart-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        /* Address Form Styles */
        .address-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #e65100;
            outline: none;
        }

        .address-toggle {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .address-toggle input {
            margin-right: 10px;
        }

        .saved-addresses {
            margin-bottom: 20px;
        }

        .address-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .address-card:hover {
            border-color: #e65100;
            background-color: #fff9f5;
        }

        .address-card.selected {
            border-color: #e65100;
            background-color: #fff9f5;
            box-shadow: 0 2px 8px rgba(230, 81, 0, 0.1);
        }

        .address-card-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .address-card-title {
            font-weight: 600;
            color: #333;
        }

        .address-card-default {
            font-size: 0.8rem;
            background-color: #e65100;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .address-card-content p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 40px 5% 20px;
            text-align: center;
            margin-top: 60px;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            margin: 10px;
            text-align: left;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            height: 2px;
            width: 40px;
            background-color: #e65100;
            bottom: 0;
            left: 0;
        }

        .footer-column p, .footer-column a {
            display: block;
            margin-bottom: 10px;
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-column a:hover {
            color: #e65100;
            padding-left: 5px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-icons a {
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: #444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: #e65100;
            transform: translateY(-5px);
        }

        .copyright {
            border-top: 1px solid #444;
            padding-top: 20px;
            font-size: 0.9rem;
            color: #999;
        }

        @media screen and (max-width: 968px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }

        @media screen and (max-width: 768px) {
            .navbar {
                padding: 1rem 4%;
            }

            .logo h1 {
                font-size: 1.2rem;
            }

            .nav-links {
                position: fixed;
                top: 80px;
                right: -100%;
                background-color: white;
                width: 70%;
                height: calc(100vh - 80px);
                flex-direction: column;
                align-items: center;
                padding-top: 2rem;
                transition: all 0.5s ease;
                box-shadow: -5px 0 10px rgba(0, 0, 0, 0.1);
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li {
                margin: 1.5rem 0;
            }

            .menu-toggle {
                display: block;
            }

            .cart-header {
                display: none;
            }

            .cart-item {
                grid-template-columns: 80px 1fr;
                gap: 15px;
                padding: 15px 0;
                position: relative;
            }

            .cart-item-details {
                grid-column: 2;
            }

            .cart-item-price, .cart-item-subtotal {
                text-align: left;
                margin-top: 5px;
            }

            .quantity-control {
                justify-content: flex-start;
                margin: 10px 0;
            }

            .remove-item {
                position: absolute;
                top: 15px;
                right: 0;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->

    <!-- Cart Section -->
    <section class="cart-section">
        <h2 class="section-title">Keranjang Belanja</h2>
        <div class="cart-layout">
            <div class="cart-container">
                @if ($cartItems->isEmpty())
                    <div class="cart-empty">
                        <h3>Keranjang belanja Anda masih kosong</h3>
                        <a href="{{ url('menu') }}" class="btn">Lihat Menu</a>
                    </div>
                @else
                    <div class="cart-header">
                        <div>Gambar</div>
                        <div>Produk</div>
                        <div>Harga</div>
                        <div>Jumlah</div>
                        <div>Total</div>
                        <div></div>
                    </div>
                    @foreach ($cartItems as $item)
                        <div class="cart-item">
                            <img src="{{ asset($item->menu->image) }}" alt="{{ $item->menu->name }}" class="cart-item-image">
                            <div class="cart-item-details">
                                <h3>{{ $item->menu->name }}</h3>
                                <p>{{ $item->menu->description }}</p>
                            </div>
                            <div class="cart-item-price">Rp {{ number_format($item->menu->price, 0, ',', '.') }}</div>
                            <div class="quantity-control">
                                <form action="{{ url('cart/update') }}" method="POST" id="updateForm{{ $item->id }}">
                                    @csrf
                                    <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                    <button type="button" class="quantity-btn decrease-btn" onclick="decreaseQuantity({{ $item->id }})">-</button>
                                    <input type="number" name="quantity" class="quantity-input" value="{{ $item->quantity }}" min="1"
                                           onchange="document.getElementById('updateForm{{ $item->id }}').submit()">
                                    <button type="button" class="quantity-btn increase-btn" onclick="increaseQuantity({{ $item->id }})">+</button>
                                </form>
                            </div>
                            <div class="cart-item-subtotal">Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}</div>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-item">×</button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
            @unless ($cartItems->isEmpty())
            <div class="cart-summary">
                <h3 class="summary-title">Ringkasan Pesanan</h3>
                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">Rp {{ number_format($cartItems->sum(fn($item) => $item->menu->price * $item->quantity), 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Biaya Pengiriman</span>
                    <span class="summary-value">Rp 10.000</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Pajak (10%)</span>
                    <span class="summary-value">Rp {{ number_format($cartItems->sum(fn($item) => $item->menu->price * $item->quantity) * 0.1, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span>Rp {{ number_format($cartItems->sum(fn($item) => $item->menu->price * $item->quantity) + 10000 + ($cartItems->sum(fn($item) => $item->menu->price * $item->quantity) * 0.1), 0, ',', '.') }}</span>
                </div>

                <!-- Address Section -->
                <div class="address-form">
                    <h3 class="summary-title">Alamat Pengiriman</h3>

                    <!-- Toggle between saved and new address -->
                    <div class="address-toggle">
                        <input type="radio" id="use-saved-address" name="address-type" value="saved" checked>
                        <label for="use-saved-address">Gunakan alamat tersimpan</label>
                    </div>
                    <div class="address-toggle">
                        <input type="radio" id="use-new-address" name="address-type" value="new">
                        <label for="use-new-address">Gunakan alamat baru</label>
                    </div>

                    <!-- Saved Addresses Section -->
                    <div id="saved-addresses-section" class="saved-addresses">
                        @if(isset($addresses) && count($addresses) > 0)
                            @foreach($addresses as $address)
                                <div class="address-card @if($address->is_default) selected @endif" data-address-id="{{ $address->id }}">
                                    <div class="address-card-header">
                                        <span class="address-card-title">{{ $address->name }}</span>
                                        @if($address->is_default)
                                            <span class="address-card-default">Utama</span>
                                        @endif
                                    </div>
                                    <div class="address-card-content">
                                        <p>{{ $address->recipient_name }}</p>
                                        <p>{{ $address->phone }}</p>
                                        <p>{{ $address->address }}, {{ $address->city }}</p>
                                        <p>{{ $address->postal_code }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>Anda belum memiliki alamat tersimpan. Silakan tambahkan alamat baru.</p>
                        @endif
                    </div>

                    <!-- New Address Form -->
                    <div id="new-address-form" style="display: none;">
                        <form id="address-form" action="{{ route('alamat.add') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="address-name">Nama Alamat</label>
                                <input type="text" id="address-name" name="address_name" class="form-control" placeholder="Contoh: Rumah, Kantor">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name">Nama Penerima</label>
                                <input type="text" id="recipient-name" name="recipient_name" class="form-control" placeholder="Nama lengkap penerima">
                            </div>

                            <div class="form-group">
                                <label for="phone">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Nomor telepon penerima">
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat Lengkap</label>
                                <textarea id="address" name="address" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW"></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">Kota</label>
                                    <input type="text" id="city" name="city" class="form-control" placeholder="Kota">
                                </div>

                                <div class="form-group">
                                    <label for="postal-code">Kode Pos</label>
                                    <input type="text" id="postal-code" name="postal_code" class="form-control" placeholder="Kode pos">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notes">Catatan (opsional)</label>
                                <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="Catatan untuk pengiriman"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="save_address" value="1" class="checkout-btn" style="margin-bottom: 10px;">Simpan alamat ini untuk penggunaan berikutnya</button>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="set_as_default" value="1" class="checkout-btn">Jadikan sebagai alamat utama</button>
                            </div>
                        </form>
                    </div>
                </div>

                <form action="{{ url('cart/checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" id="selected-address-id" name="address_id" value="">
                    <button type="submit" class="checkout-btn">Lanjut ke Pembayaran</button>
                </form>
            </div>
            @endunless
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Ayam Goreng Lezat</h3>
                <p>Menyajikan ayam goreng berkualitas dengan resep rahasia turun temurun sejak 2005.</p>
                <div class="social-icons">
                    <a href="#"><span>FB</span></a>
                    <a href="#"><span>IG</span></a>
                    <a href="#"><span>TW</span></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Jam Operasional</h3>
                <p>Senin - Jumat: 10:00 - 22:00</p>
                <p>Sabtu - Minggu: 09:00 - 23:00</p>
                <p>Hari Libur: 09:00 - 23:00</p>
            </div>
            <div class="footer-column">
                <h3>Tautan Cepat</h3>
                <a href="#">Beranda</a>
                <a href="#">Menu</a>
                <a href="#">Promo</a>
                <a href="#">Lokasi</a>
                <a href="#">Kontak</a>
            </div>
            <div class="footer-column">
                <h3>Hubungi Kami</h3>
                <p>Jl. Ayam Goreng No. 123</p>
                <p>Kota Lezat, 12345</p>
                <p>info@ayamgorenglezat.com</p>
                <p>+62 8123 4567 890</p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Ayam Goreng Lezat. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        // Functions to increase and decrease quantity
        function increaseQuantity(itemId) {
            const form = document.getElementById('updateForm' + itemId);
            const input = form.querySelector('.quantity-input');
            input.value = parseInt(input.value) + 1;
            form.submit();
        }

        function decreaseQuantity(itemId) {
            const form = document.getElementById('updateForm' + itemId);
            const input = form.querySelector('.quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                form.submit();
            }
        }

        // Toggle Menu for Mobile
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }

        // Address form toggle
        const useSavedAddressRadio = document.getElementById('use-saved-address');
        const useNewAddressRadio = document.getElementById('use-new-address');
        const savedAddressesSection = document.getElementById('saved-addresses-section');
        const newAddressForm = document.getElementById('new-address-form');
        const selectedAddressIdInput = document.getElementById('selected-address-id');

        // Set default address ID if available
        document.addEventListener('DOMContentLoaded', function() {
            const defaultAddressCard = document.querySelector('.address-card.selected');
            if (defaultAddressCard) {
                selectedAddressIdInput.value = defaultAddressCard.dataset.addressId;
            }
        });

        // Toggle between saved and new address
        if (useSavedAddressRadio && useNewAddressRadio) {
            useSavedAddressRadio.addEventListener('change', function() {
                if (this.checked) {
                    savedAddressesSection.style.display = 'block';
                    newAddressForm.style.display = 'none';

                    // Reset selected address ID to default if available
                    const defaultAddressCard = document.querySelector('.address-card.selected');
                    if (defaultAddressCard) {
                        selectedAddressIdInput.value = defaultAddressCard.dataset.addressId;
                    }
                }
            });

            useNewAddressRadio.addEventListener('change', function() {
                if (this.checked) {
                    savedAddressesSection.style.display = 'none';
                    newAddressForm.style.display = 'block';
                    selectedAddressIdInput.value = 'new';
                }
            });
        }

        // Make address cards selectable
        const addressCards = document.querySelectorAll('.address-card');
        addressCards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                addressCards.forEach(c => c.classList.remove('selected'));

                // Add selected class to clicked card
                this.classList.add('selected');

                // Update hidden input with selected address ID
                selectedAddressIdInput.value = this.dataset.addressId;
            });
        });
    </script>
</body>
</html>
@endsection

