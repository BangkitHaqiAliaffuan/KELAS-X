@extends('admin.layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
<h2 class="mb-4">Manage Users</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="tables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Joined Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>

                                <button onclick="deleteUser({{ $user->id }})"
                                        class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Enhanced Epic Games Inspired Admin Theme */
:root {
  --epic-dark: #121212;
  --epic-darker: #0a0a0a;
  --epic-blue: #037bfc;
  --epic-blue-hover: #0366d6;
  --epic-blue-glow: rgba(3, 123, 252, 0.4);
  --epic-red: #e63946;
  --epic-red-hover: #d32f2f;
  --epic-red-glow: rgba(230, 57, 70, 0.4);
  --epic-text: #f5f5f5;
  --epic-text-secondary: #a0a0a0;
  --epic-border: #2a2a2a;
  --epic-card: #202020;
  --epic-hover: #2a2a2a;
  --epic-yellow: #ffb703;
  --epic-purple: #7209b7;
  --epic-gradient: linear-gradient(135deg, #037bfc 0%, #7209b7 100%);
}

/* Base Styles */
body {
  background-color: var(--epic-dark);
  background-image: radial-gradient(circle at 25% 25%, rgba(3, 123, 252, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 75% 75%, rgba(114, 9, 183, 0.05) 0%, transparent 50%);
  color: var(--epic-text);
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  min-height: 100vh;
  line-height: 1.6;
}

/* Typography */
h2 {
  font-size: 2.25rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: var(--epic-text);
  position: relative;
  padding-bottom: 0.75rem;
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
  background-color: var(--epic-card);
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
.table-responsive {
  overflow-x: auto;
  border-radius: 8px;
  background: rgba(10, 10, 10, 0.3);
  padding: 0.5rem;
}

.tables {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  color: var(--epic-text);
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
  background-color: var(--epic-hover);
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
}

/* Email Column Styling */
.tables td:nth-child(2) {
  font-family: monospace;
  font-size: 0.9rem;
}

/* Date Column Styling */
.tables td:nth-child(5) {
  font-family: monospace;
  color: var(--epic-text-secondary);
}

/* Role Column Styling */
.tables td:nth-child(4) {
  text-transform: uppercase;
  font-size: 0.8rem;
  letter-spacing: 0.5px;
  font-weight: 600;
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

.btn-sm {
  padding: 0.375rem 0.75rem;
  font-size: 0.8rem;
  border-radius: 4px;
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

.btn-danger:active {
  transform: translateY(0);
}

/* Epic Games style pagination */
.pagination {
  display: flex;
  padding-left: 0;
  list-style: none;
  border-radius: 8px;
  margin-top: 1.5rem;
  justify-content: center;
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
  color: var(--epic-text);
  background-color: var(--epic-card);
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
  background-color: var(--epic-hover);
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* SweetAlert Customization */
.swal2-popup {
  background-color: var(--epic-card) !important;
  color: var(--epic-text) !important;
  border-radius: 12px !important;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4) !important;
  border: 1px solid var(--epic-border) !important;
  padding: 2rem !important;
}

.swal2-title {
  color: var(--epic-text) !important;
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

/* Text center utility */
.text-center {
  text-align: center;
}

/* Empty state styling */
.tables tr:only-child td {
  padding: 3rem 1rem;
  text-align: center;
  font-size: 1.1rem;
  color: var(--epic-text-secondary);
  background: rgba(10, 10, 10, 0.2);
}

.tables tr:only-child td::before {
  content: "📋";
  display: block;
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
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
}

@media (max-width: 768px) {
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

/* Loading animation for potential async operations */
@keyframes epicPulse {
  0% {
    opacity: 0.6;
    transform: scale(0.98);
  }
  50% {
    opacity: 1;
    transform: scale(1);
  }
  100% {
    opacity: 0.6;
    transform: scale(0.98);
  }
}

.loading {
  animation: epicPulse 1.5s infinite;
  pointer-events: none;
}

/* Epic Games inspired focus styles */
*:focus {
  outline: none;
  box-shadow: 0 0 0 3px var(--epic-blue-glow);
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

</style>

@endsection



@section('scripts')
<script>
 var baseUrl = "{{ url('/admin/users') }}";
    function deleteUser(id) {
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
