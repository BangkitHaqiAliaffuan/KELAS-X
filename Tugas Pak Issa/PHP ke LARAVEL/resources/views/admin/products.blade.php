@extends('admin.layouts.app')

@section('title', 'Manage Games - Admin')



@section('content')
<div class="header-container">
    <h2>Manage Games</h2>
    <a href="{{ route('admin.products.add') }}" class="btn btn-epic">
        <i class="fas fa-plus-circle"></i> Add New Game
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-container">
            <table class="tables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <img src="{{ asset('uploads/' . $product->image) }}" alt="{{ $product->name }}"
                                     class="product-thumbnail">
                            </td>
                            <td class="product-name">{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'No Category' }}</td>
                            <td>Rp. {{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($product->release_status) }}">
                                    {{ ucfirst($product->release_status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="deleteProduct({{ $product->id }})"
                                            class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-container">
                                    <i class="fas fa-gamepad empty-icon"></i>
                                    <p>No games found in your inventory</p>
                                    <a href="{{ route('admin.products.add') }}" class="btn btn-epic">
                                        Add Your First Game
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($products, 'links'))
            <div class="pagination-container">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Enhanced Epic Games Inspired Admin Theme - Products Page */
:root {
  --epic-black: #121212;
  --epic-dark: #202020;
  --epic-darker: #0a0a0a;
  --epic-gray: #2a2a2a;
  --epic-light-gray: #3a3a3a;
  --epic-blue: #037bfc;
  --epic-blue-hover: #0366d6;
  --epic-blue-glow: rgba(3, 123, 252, 0.4);
  --epic-red: #e63946;
  --epic-red-hover: #d32f2f;
  --epic-red-glow: rgba(230, 57, 70, 0.4);
  --epic-white: #f5f5f5;
  --epic-text-secondary: #a0a0a0;
  --epic-border: #333333;
  --epic-yellow: #ffb703;
  --epic-purple: #7209b7;
  --epic-green: #2ecc71;
  --epic-orange: #f39c12;
  --epic-gradient: linear-gradient(135deg, #037bfc 0%, #7209b7 100%);
}

/* Base Styles */
body {
  background-color: var(--epic-black);
  background-image: radial-gradient(circle at 25% 25%, rgba(3, 123, 252, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 75% 75%, rgba(114, 9, 183, 0.05) 0%, transparent 50%);
  color: var(--epic-white);
  font-family: "Segoe UI", Roboto, -apple-system, BlinkMacSystemFont, sans-serif;
  margin: 0;
  padding: 0;
  line-height: 1.6;
}

/* Header Container */
.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  position: relative;
}

.header-container::after {
  content: "";
  position: absolute;
  bottom: -1rem;
  left: 0;
  width: 100%;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--epic-blue), transparent);
}

/* Typography */
h2 {
  font-size: 2.25rem;
  font-weight: 700;
  margin-bottom: 0;
  color: var(--epic-white);
  position: relative;
  padding-bottom: 0.5rem;
  letter-spacing: -0.5px;
  text-transform: uppercase;
}

h2::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 80px;
  height: 4px;
  background: var(--epic-gradient);
  border-radius: 2px;
}

/* Card Styling */
.card {
  background-color: var(--epic-dark);
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  border: 1px solid var(--epic-border);
  margin-bottom: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
}

.card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: var(--epic-gradient);
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
}

.card-body {
  padding: 2rem;
}

/* Table Styling */
.table-container {
  overflow-x: auto;
  border-radius: 8px;
  background: rgba(10, 10, 10, 0.3);
  padding: 0.5rem;
}

.tables {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  color: var(--epic-white);
}

.tables thead {
  background-color: var(--epic-darker);
}

.tables th {
  padding: 1.25rem 1rem;
  text-align: left;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.8rem;
  letter-spacing: 1px;
  color: var(--epic-blue);
  border-bottom: 2px solid var(--epic-blue);
  position: relative;
}

.tables th::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: var(--epic-gradient);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.tables thead:hover th::after {
  transform: scaleX(1);
}

.tables td {
  padding: 1.25rem 1rem;
  border-bottom: 1px solid rgba(42, 42, 42, 0.7);
  vertical-align: middle;
  transition: all 0.2s ease;
}

.tables tbody tr {
  transition: all 0.3s ease;
  position: relative;
}

.tables tbody tr:hover {
  background-color: var(--epic-gray);
  transform: translateX(5px);
}

.tables tbody tr:hover td {
  color: white;
}

.tables tbody tr:last-child td {
  border-bottom: none;
}

.tables tbody tr:nth-child(odd) {
  background-color: rgba(10, 10, 10, 0.2);
}

/* ID Column Styling */
.tables td:first-child {
  font-weight: 600;
  color: var(--epic-blue);
  font-family: monospace;
}

/* Product Thumbnail */
.product-thumbnail {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.tables tr:hover .product-thumbnail {
  transform: scale(1.1);
  border-color: var(--epic-blue);
  box-shadow: 0 8px 20px rgba(3, 123, 252, 0.3);
}

/* Product Name */
.product-name {
  font-weight: 600;
  font-size: 1.1rem;
  color: var(--epic-white);
  transition: all 0.2s ease;
}

.tables tr:hover .product-name {
  color: var(--epic-blue);
}

/* Price Column */
.tables td:nth-child(5) {
  font-family: monospace;
  font-weight: 600;
  color: var(--epic-green);
}

/* Status Badges */
.status-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
}

.tables tr:hover .status-badge {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

.status-released {
  background: linear-gradient(135deg, #2ecc71, #27ae60);
  color: white;
}

.status-upcoming {
  background: linear-gradient(135deg, #f39c12, #e67e22);
  color: white;
}

.status-early-access {
  background: linear-gradient(135deg, #9b59b6, #8e44ad);
  color: white;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 0.75rem;
}

/* Button Styling */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  user-select: none;
  border: 1px solid transparent;
  padding: 0.625rem 1.25rem;
  font-size: 0.9rem;
  line-height: 1.5;
  border-radius: 6px;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  position: relative;
  overflow: hidden;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  text-decoration: none;
}

.btn i {
  margin-right: 0.5rem;
  font-size: 1rem;
}

.btn::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.1);
  transform: translateX(-100%);
  transition: transform 0.3s ease;
}

.btn:hover::before {
  transform: translateX(0);
}

.btn-epic {
  background: var(--epic-gradient);
  color: white;
  box-shadow: 0 4px 10px var(--epic-blue-glow);
}

.btn-epic:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 15px var(--epic-blue-glow);
}

.btn-sm {
  padding: 0.375rem 0.75rem;
  font-size: 0.8rem;
  border-radius: 4px;
}

.btn-primary {
  background-color: var(--epic-blue);
  color: white;
  box-shadow: 0 4px 10px rgba(3, 123, 252, 0.2);
}

.btn-primary:hover {
  background-color: var(--epic-blue-hover);
  box-shadow: 0 6px 15px var(--epic-blue-glow);
  transform: translateY(-2px);
}

.btn-danger {
  background-color: var(--epic-red);
  color: white;
  box-shadow: 0 4px 10px rgba(230, 57, 70, 0.2);
}

.btn-danger:hover {
  background-color: var(--epic-red-hover);
  box-shadow: 0 6px 15px var(--epic-red-glow);
  transform: translateY(-2px);
}

/* Empty State */
.empty-state {
  padding: 4rem 2rem !important;
  text-align: center;
}

.empty-state-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.empty-icon {
  font-size: 4rem;
  color: var(--epic-blue);
  background: linear-gradient(135deg, var(--epic-blue), var(--epic-purple));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 0.5rem;
}

.empty-state-container p {
  font-size: 1.25rem;
  color: var(--epic-text-secondary);
  margin-bottom: 1.5rem;
}

/* Pagination */
.pagination-container {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

.pagination {
  display: flex;
  padding-left: 0;
  list-style: none;
  border-radius: 8px;
  gap: 0.5rem;
}

.pagination li {
  margin: 0;
}

.pagination li a,
.pagination li span {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 40px;
  min-width: 40px;
  padding: 0 0.75rem;
  line-height: 1.25;
  color: var(--epic-white);
  background-color: var(--epic-gray);
  border: 1px solid var(--epic-border);
  text-decoration: none;
  border-radius: 6px;
  transition: all 0.2s ease;
  font-weight: 500;
}

.pagination li.active span {
  background: var(--epic-gradient);
  border-color: var(--epic-blue);
  color: white;
  box-shadow: 0 4px 10px var(--epic-blue-glow);
}

.pagination li a:hover {
  background-color: var(--epic-light-gray);
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* SweetAlert Customization */
.swal2-popup {
  background-color: var(--epic-dark) !important;
  color: var(--epic-white) !important;
  border-radius: 12px !important;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4) !important;
  border: 1px solid var(--epic-border) !important;
  padding: 2rem !important;
}

.swal2-title {
  color: var(--epic-white) !important;
  font-weight: 700 !important;
  font-size: 1.75rem !important;
}

.swal2-content {
  color: var(--epic-text-secondary) !important;
  font-size: 1.1rem !important;
}

.swal2-confirm {
  background: var(--epic-red) !important;
  box-shadow: 0 4px 15px var(--epic-red-glow) !important;
  border-radius: 6px !important;
  padding: 0.75rem 1.5rem !important;
  font-weight: 600 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  transition: all 0.2s ease !important;
}

.swal2-confirm:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 6px 20px var(--epic-red-glow) !important;
}

.swal2-cancel {
  background: var(--epic-blue) !important;
  box-shadow: 0 4px 15px var(--epic-blue-glow) !important;
  border-radius: 6px !important;
  padding: 0.75rem 1.5rem !important;
  font-weight: 600 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  transition: all 0.2s ease !important;
}

.swal2-cancel:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 6px 20px var(--epic-blue-glow) !important;
}

.swal2-icon {
  border-color: var(--epic-yellow) !important;
  color: var(--epic-yellow) !important;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}

::-webkit-scrollbar-track {
  background: var(--epic-darker);
  border-radius: 5px;
}

::-webkit-scrollbar-thumb {
  background: var(--epic-blue);
  border-radius: 5px;
  background-image: var(--epic-gradient);
}

::-webkit-scrollbar-thumb:hover {
  background: var(--epic-blue-hover);
}

/* Epic Games Logo-inspired element */
.card::after {
  content: "";
  position: absolute;
  top: 1rem;
  right: 1rem;
  width: 40px;
  height: 40px;
  background-image: linear-gradient(135deg, var(--epic-blue) 0%, var(--epic-purple) 100%);
  clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 80%, 80% 80%, 80% 20%, 0% 20%);
  opacity: 0.1;
}

/* Game-specific styling */
.tables td:nth-child(4) {
  /* Category column */
  position: relative;
  font-weight: 500;
}

.tables td:nth-child(4)::before {
  content: "#";
  color: var(--epic-blue);
  margin-right: 2px;
  font-weight: bold;
}

/* Add a subtle hover effect to the entire row */
.tables tbody tr::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 3px;
  background: var(--epic-gradient);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.tables tbody tr:hover::after {
  opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .card-body {
    padding: 1.5rem;
  }

  .tables th,
  .tables td {
    padding: 1rem 0.75rem;
  }

  h2 {
    font-size: 2rem;
  }

  .product-thumbnail {
    width: 60px;
    height: 60px;
  }
}

@media (max-width: 768px) {
  .header-container {
    flex-direction: column;
    align-items: flex-start;
    gap: 1.5rem;
  }

  .tables th,
  .tables td {
    padding: 0.75rem 0.5rem;
    font-size: 0.9rem;
  }

  h2 {
    font-size: 1.75rem;
  }

  .card::after {
    display: none;
  }

  .tables tbody tr:hover {
    transform: none;
  }

  .action-buttons {
    flex-direction: column;
    gap: 0.5rem;
  }

  .product-name {
    font-size: 1rem;
  }
}

@media (max-width: 576px) {
  .card-body {
    padding: 1rem;
  }

  .tables th {
    font-size: 0.7rem;
  }

  .tables td {
    font-size: 0.8rem;
  }

  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }

  .product-thumbnail {
    width: 50px;
    height: 50px;
  }

  .status-badge {
    padding: 0.35rem 0.7rem;
    font-size: 0.7rem;
  }
}

/* Game-specific animations */
@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

.btn-epic:hover i {
  animation: pulse 1s infinite;
}

/* Epic Games inspired focus styles */
*:focus {
  outline: none;
  box-shadow: 0 0 0 3px var(--epic-blue-glow);
}

/* Add a cool hover effect for the "Add New Game" button */
.header-container .btn-epic {
  position: relative;
  overflow: hidden;
  z-index: 1;
}

.header-container .btn-epic::after {
  content: "";
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
  opacity: 0;
  transform: scale(0.5);
  transition: transform 0.5s ease, opacity 0.5s ease;
  z-index: -1;
}

.header-container .btn-epic:hover::after {
  opacity: 1;
  transform: scale(1);
}

</style>

@endsection

@section('scripts')
<script>
    var baseUrl = "{{ url('/admin/products') }}";
    function deleteProduct(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e63946',
            cancelButtonColor: '#037BFC',
            confirmButtonText: 'Yes, delete it!',
            background: '#202020',
            color: '#f5f5f5'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = baseUrl + '/delete/' + id;
                form.style.display = 'none';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endsection
