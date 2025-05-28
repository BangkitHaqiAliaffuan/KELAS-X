import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useForm } from 'react-hook-form';
import { useAuth } from '../context/AuthContext';
import { useNavigate } from 'react-router-dom';

const Admin = () => {
  const navigate = useNavigate();
  const { user, isAuthenticated, logout } = useAuth();
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [currentPage, setCurrentPage] = useState(1);
  const [usersPerPage] = useState(10);
  const [selectedUser, setSelectedUser] = useState(null);
  const [showDetailModal, setShowDetailModal] = useState(false);
  const [showAddModal, setShowAddModal] = useState(false);
  const [updateLoading, setUpdateLoading] = useState(false);
  const [submitLoading, setSubmitLoading] = useState(false);
  const [submitError, setSubmitError] = useState(null);
  const [submitSuccess, setSubmitSuccess] = useState(false);
  const { register, handleSubmit, reset, formState: { errors } } = useForm();

  // Cek apakah user memiliki akses ke halaman admin
  useEffect(() => {
    if (!isAuthenticated) {
      navigate('/login');
    } else if (user && user.level !== 'admin') {
      // Redirect ke halaman yang sesuai dengan level user
      if (user.level === 'kasir') {
        navigate('/order');
      } else if (user.level === 'koki') {
        navigate('/allorderdetails');
      }
    }
  }, [isAuthenticated, user, navigate]);

  // Fungsi untuk mengambil data user dari API
  const fetchUsers = async () => {
    try {
      setLoading(true);
      
      // Ambil token dari localStorage
      const token = localStorage.getItem('adminToken');
      
      // Buat konfigurasi header dengan token
      const config = {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      };
      
      const response = await axios.get('http://localhost:8000/api/users', config);
      setUsers(response.data.users);
      setLoading(false);
    } catch (err) {
      setError('Terjadi kesalahan saat mengambil data user');
      console.error('Error fetching users:', err);
      setLoading(false);
      
      // Jika error 401 (Unauthorized), redirect ke login
      if (err.response && (err.response.status === 401 || err.response.status === 403)) {
        navigate('/login');
      }
    }
  };

  useEffect(() => {
    if (isAuthenticated && user && user.level === 'admin') {
      fetchUsers();
    }
  }, [isAuthenticated, user]);

  // Logika pagination
  const indexOfLastUser = currentPage * usersPerPage;
  const indexOfFirstUser = indexOfLastUser - usersPerPage;
  const currentUsers = users.slice(indexOfFirstUser, indexOfLastUser);
  const totalPages = Math.ceil(users.length / usersPerPage);

  // Fungsi untuk mengganti halaman
  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  // Fungsi untuk menampilkan detail user
  const showUserDetail = (user) => {
    setSelectedUser(user);
    setShowDetailModal(true);
  };

  // Fungsi untuk menutup modal detail
  const closeDetailModal = () => {
    setShowDetailModal(false);
    setSelectedUser(null);
  };

  // Fungsi untuk mengubah status user
  const toggleStatus = async (user) => {
    try {
      setUpdateLoading(true);
      
      // Ambil token dari localStorage
      const token = localStorage.getItem('adminToken');
      
      // Buat konfigurasi header dengan token
      const config = {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      };
      
      await axios.put(`http://localhost:8000/api/users/${user.id}/status`, {}, config);
      fetchUsers(); // Refresh data setelah update
    } catch (err) {
      setError('Terjadi kesalahan saat mengubah status user');
      console.error('Error updating user status:', err);
      
      // Jika error 401 (Unauthorized), redirect ke login
      if (err.response && (err.response.status === 401 || err.response.status === 403)) {
        navigate('/login');
      }
    } finally {
      setUpdateLoading(false);
    }
  };

  // Fungsi untuk menambahkan user baru
  const addUser = async (data) => {
    try {
      setSubmitLoading(true);
      setSubmitError(null);
      setSubmitSuccess(false);
      
      // Ambil token dari localStorage
      const token = localStorage.getItem('adminToken');
      
      // Buat konfigurasi header dengan token
      const config = {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      };
      
      // Perbaikan: pastikan field 'name' diubah menjadi 'user' untuk request ke API
      const requestData = {
        ...data,
        user: data.name // Menyalin nilai dari 'name' ke 'user' untuk request ke API
      };
      
      const response = await axios.post('http://localhost:8000/api/register', requestData, config);
      
      setSubmitSuccess(true);
      setTimeout(() => {
        setShowAddModal(false);
        reset();
        fetchUsers(); // Refresh data setelah berhasil menambahkan
        setSubmitSuccess(false);
      }, 1500);
    } catch (err) {
      setSubmitError(err.response?.data?.message || 'Terjadi kesalahan saat menambahkan user');
      console.error('Error adding user:', err);
      
      // Jika error 401 (Unauthorized), redirect ke login
      if (err.response && (err.response.status === 401 || err.response.status === 403)) {
        navigate('/login');
      }
    } finally {
      setSubmitLoading(false);
    }
  };
  
  // Fungsi untuk menutup modal tambah user
  const closeAddModal = () => {
    setShowAddModal(false);
    setSubmitError(null);
    setSubmitSuccess(false);
    reset();
  };

  return (
    <div className="admin-page">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Manajemen User</h2>
        {isAuthenticated && user && (
          <div className="d-flex align-items-center">
            <span className="me-3">
              <strong>Login sebagai:</strong> {user.user} ({user.level})
            </span>
            <button 
              className="btn btn-danger btn-sm" 
              onClick={logout}
            >
              <i className="bi bi-box-arrow-right"></i> Logout
            </button>
          </div>
        )}
      </div>
      
      {error && (
        <div className="alert alert-danger" role="alert">
          {error}
        </div>
      )}

      <div className="card">
        <div className="card-header d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Daftar User</h5>
          <div>
            <button 
              className="btn btn-success btn-sm me-2" 
              onClick={() => setShowAddModal(true)}
            >
              <i className="bi bi-person-plus"></i> Tambah User
            </button>
            <button 
              className="btn btn-primary btn-sm" 
              onClick={fetchUsers}
            >
              <i className="bi bi-arrow-clockwise"></i> Refresh
            </button>
          </div>
        </div>
        <div className="card-body">
          {loading ? (
            <div className="text-center">
              <div className="spinner-border text-primary" role="status">
                <span className="visually-hidden">Loading...</span>
              </div>
              <p className="mt-2">Memuat data user...</p>
            </div>
          ) : users.length === 0 ? (
            <p className="text-center">Tidak ada data user yang tersedia.</p>
          ) : (
            <>
              <div className="table-responsive">
                <table className="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Level</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    {currentUsers.map((user, index) => (
                      <tr key={user.id}>
                        <td>{indexOfFirstUser + index + 1}</td>
                        <td>{user.name}</td>
                        <td>{user.email}</td>
                        <td>
                          <span className={`badge ${user.level === 'admin' ? 'bg-danger' : 'bg-success'}`}>
                            {user.level}
                          </span>
                        </td>
                        <td>
                          <span className={`badge ${user.status === 1 ? 'bg-success' : 'bg-secondary'}`}>
                            {user.status === 1 ? 'Aktif' : 'Tidak Aktif'}
                          </span>
                        </td>
                        <td>
                          <div className="btn-group">
                            <button 
                              className="btn btn-info btn-sm" 
                              onClick={() => showUserDetail(user)}
                            >
                              <i className="bi bi-eye"></i> Detail
                            </button>
                            <button 
                              className={`btn btn-${user.status === 1 ? 'warning' : 'success'} btn-sm`}
                              onClick={() => toggleStatus(user)}
                              disabled={updateLoading}
                            >
                              <i className={`bi bi-${user.status === 1 ? 'ban' : 'check-circle'}`}></i>
                              {user.status === 1 ? ' Ban' : ' Aktifkan'}
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>

              {/* Pagination */}
              {totalPages > 1 && (
                <nav aria-label="Page navigation">
                  <ul className="pagination justify-content-center">
                    <li className={`page-item ${currentPage === 1 ? 'disabled' : ''}`}>
                      <button 
                        className="page-link" 
                        onClick={() => paginate(currentPage - 1)}
                        disabled={currentPage === 1}
                      >
                        &laquo;
                      </button>
                    </li>
                    {[...Array(totalPages).keys()].map(number => (
                      <li key={number + 1} className={`page-item ${currentPage === number + 1 ? 'active' : ''}`}>
                        <button 
                          className="page-link" 
                          onClick={() => paginate(number + 1)}
                        >
                          {number + 1}
                        </button>
                      </li>
                    ))}
                    <li className={`page-item ${currentPage === totalPages ? 'disabled' : ''}`}>
                      <button 
                        className="page-link" 
                        onClick={() => paginate(currentPage + 1)}
                        disabled={currentPage === totalPages}
                      >
                        &raquo;
                      </button>
                    </li>
                  </ul>
                </nav>
              )}
            </>
          )}
        </div>
      </div>

      {/* Modal Detail User */}
      {showDetailModal && selectedUser && (
        <div className="modal fade show" style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Detail User</h5>
                <button type="button" className="btn-close" onClick={closeDetailModal}></button>
              </div>
              <div className="modal-body">
                <div className="mb-3">
                  <strong>ID:</strong> {selectedUser.id}
                </div>
                <div className="mb-3">
                  <strong>Nama:</strong> {selectedUser.name}
                </div>
                <div className="mb-3">
                  <strong>Email:</strong> {selectedUser.email}
                </div>
                <div className="mb-3">
                  <strong>Level:</strong> {selectedUser.level}
                </div>
                <div className="mb-3">
                  <strong>Status:</strong> {selectedUser.status === 1 ? 'Aktif' : 'Tidak Aktif'}
                </div>
                <div className="mb-3">
                  <strong>Tanggal Dibuat:</strong> {new Date(selectedUser.created_at).toLocaleString('id-ID')}
                </div>
                {selectedUser.updated_at && (
                  <div className="mb-3">
                    <strong>Terakhir Diperbarui:</strong> {new Date(selectedUser.updated_at).toLocaleString('id-ID')}
                  </div>
                )}
              </div>
              <div className="modal-footer">
                <button type="button" className="btn btn-secondary" onClick={closeDetailModal}>Tutup</button>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Modal Tambah User */}
      {showAddModal && (
        <div className="modal fade show" style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Tambah User Baru</h5>
                <button type="button" className="btn-close" onClick={closeAddModal}></button>
              </div>
              <div className="modal-body">
                {submitError && (
                  <div className="alert alert-danger">{submitError}</div>
                )}
                {submitSuccess && (
                  <div className="alert alert-success">User berhasil ditambahkan!</div>
                )}
                <form onSubmit={handleSubmit(addUser)}>
                  <div className="mb-3">
                    <label htmlFor="name" className="form-label">Nama</label>
                    <input 
                      type="text" 
                      className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                      id="name"
                      {...register('name', { required: 'Nama harus diisi' })}
                    />
                    {errors.name && (
                      <div className="invalid-feedback">{errors.name.message}</div>
                    )}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="email" className="form-label">Email</label>
                    <input 
                      type="email" 
                      className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                      id="email"
                      {...register('email', { 
                        required: 'Email harus diisi',
                        pattern: {
                          value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                          message: 'Email tidak valid'
                        }
                      })}
                    />
                    {errors.email && (
                      <div className="invalid-feedback">{errors.email.message}</div>
                    )}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="relasi" className="form-label">Relasi</label>
                    <input 
                      type="text" 
                      className={`form-control ${errors.relasi ? 'is-invalid' : ''}`}
                      id="relasi"
                      {...register('relasi', { 
                        required: 'Relasi harus diisi'
                      })}
                    />
                    {errors.relasi && (
                      <div className="invalid-feedback">{errors.relasi.message}</div>
                    )}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="password" className="form-label">Password</label>
                    <input 
                      type="password" 
                      className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                      id="password"
                      {...register('password', { 
                        required: 'Password harus diisi',
                        minLength: {
                          value: 6,
                          message: 'Password minimal 6 karakter'
                        }
                      })}
                    />
                    {errors.password && (
                      <div className="invalid-feedback">{errors.password.message}</div>
                    )}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="level" className="form-label">Level</label>
                    <select 
                      className={`form-select ${errors.level ? 'is-invalid' : ''}`}
                      id="level"
                      {...register('level', { required: 'Level harus dipilih' })}
                    >
                      <option value="">Pilih Level</option>
                      <option value="admin">Admin</option>
                      <option value="kasir">Kasir</option>
                      <option value="koki">Koki</option>
                    </select>
                    {errors.level && (
                      <div className="invalid-feedback">{errors.level.message}</div>
                    )}
                  </div>
                  <div className="modal-footer">
                    <button type="button" className="btn btn-secondary" onClick={closeAddModal}>Batal</button>
                    <button 
                      type="submit" 
                      className="btn btn-primary"
                      disabled={submitLoading}
                    >
                      {submitLoading ? (
                        <>
                          <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                          Menyimpan...
                        </>
                      ) : 'Simpan'}
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Admin;