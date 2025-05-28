import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useForm } from 'react-hook-form';
import useConfirmDelete from '../hooks/useConfirmDelete';

const Menu = () => {
  const [menus, setMenus] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showAddModal, setShowAddModal] = useState(false);
  const [showEditModal, setShowEditModal] = useState(false);
  const [currentMenu, setCurrentMenu] = useState(null);
  const [categories, setCategories] = useState([]);
  const [imagePreview, setImagePreview] = useState('');
  
  const { register, handleSubmit, reset, setValue, formState: { errors } } = useForm();
  
  // Custom hook untuk konfirmasi delete
  const { showConfirm, itemToDelete, confirmDelete, cancelDelete, handleDelete } = 
    useConfirmDelete((menu) => deleteMenu(menu.idmenu));

  // useEffect dengan cleanup function
  useEffect(() => {
    let isMounted = true;
    const controller = new AbortController();
    
    const fetchData = async () => {
      try {
        setLoading(true);
        const [menuResponse, categoryResponse] = await Promise.all([
          axios.get('http://localhost:8000/api/menus', { signal: controller.signal }),
          axios.get('http://localhost:8000/api/kategoris', { signal: controller.signal })
        ]);
        
        if (isMounted) {
          setMenus(Array.isArray(menuResponse.data.data) ? menuResponse.data.data : []);
          setCategories(categoryResponse.data || []);
          setLoading(false);
        }
      } catch (err) {
        if (err.name !== 'AbortError' && isMounted) {
          setError('Terjadi kesalahan saat mengambil data');
          console.error('Error fetching data:', err);
          setLoading(false);
        }
      }
    };
    
    fetchData();
    
    // Cleanup function
    return () => {
      isMounted = false;
      controller.abort();
    };
  }, []);
  
  const fetchMenus = async () => {
    try {
      setLoading(true);
      const response = await axios.get('http://localhost:8000/api/menus');
      setMenus(Array.isArray(response.data.data) ? response.data.data : []);
      setLoading(false);
    } catch (err) {
      setError('Terjadi kesalahan saat mengambil data menu');
      console.error('Error fetching menus:', err);
      setLoading(false);
    }
  };
  
  // Fungsi untuk menambah menu baru
  const addMenu = async (data) => {
    try {
      const formData = new FormData();
      formData.append('menu', data.menu);
      formData.append('idkategori', data.idkategori);
      formData.append('harga', data.harga);
      formData.append('gambar', data.gambar[0]);
      
      await axios.post('http://localhost:8000/api/menus', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      
      fetchMenus();
      setShowAddModal(false);
      reset();
      setImagePreview('');
    } catch (err) {
      console.error('Error adding menu:', err);
      setError('Terjadi kesalahan saat menambah menu');
    }
  };
  
  // Fungsi untuk update menu
  const updateMenu = async (data) => {
    try {
      const formData = new FormData();
      formData.append('menu', data.menu);
      formData.append('idkategori', data.idkategori);
      formData.append('harga', data.harga);
      formData.append('_method', 'PUT');
      
      if (data.gambar && data.gambar.length > 0) {
        formData.append('gambar', data.gambar[0]);
      }
      
      await axios.post(`http://localhost:8000/api/menus/${currentMenu.idmenu}`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      
      fetchMenus();
      setShowEditModal(false);
      setCurrentMenu(null);
      reset();
      setImagePreview('');
    } catch (err) {
      console.error('Error updating menu:', err);
      setError('Terjadi kesalahan saat mengupdate menu');
    }
  };
  
  // Fungsi untuk menghapus menu
  const deleteMenu = async (id) => {
    try {
      await axios.delete(`http://localhost:8000/api/menus/${id}`);
      fetchMenus();
    } catch (err) {
      console.error('Error deleting menu:', err);
      setError('Terjadi kesalahan saat menghapus menu');
    }
  };
  
  // Fungsi untuk membuka modal edit dan mengisi form
  const openEditModal = (menu) => {
    setCurrentMenu(menu);
    setValue('menu', menu.menu);
    setValue('idkategori', menu.idkategori.toString());
    setValue('harga', menu.harga);
    setImagePreview(`/uploads/${menu.gambar.split('/').pop()}`);
    setShowEditModal(true);
  };
  
  // Fungsi untuk menangani preview gambar
  const handleImageChange = (e) => {
    if (e.target.files && e.target.files[0]) {
      setImagePreview(URL.createObjectURL(e.target.files[0]));
    }
  };

  return (
    <div className="menu-page">
      <h2 className="mb-4">Menu</h2>
      <div className="card">
        <div className="card-header d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Daftar Menu</h5>
          <button 
            className="btn btn-primary btn-sm"
            onClick={() => {
              reset();
              setImagePreview('');
              setShowAddModal(true);
            }}
          >
            <i className="bi bi-plus"></i> Tambah Menu
          </button>
        </div>
        <div className="card-body">
          {loading ? (
            <div className="text-center">
              <div className="spinner-border text-primary" role="status">
                <span className="visually-hidden">Loading...</span>
              </div>
              <p className="mt-2">Memuat data menu...</p>
            </div>
          ) : error ? (
            <div className="alert alert-danger">{error}</div>
          ) : menus.length === 0 ? (
            <div className="alert alert-info">Tidak ada data menu tersedia.</div>
          ) : (
            <div className="table-responsive">
              <table className="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  {menus.map((menu, index) => (
                    <tr key={menu.idmenu}>
                      <td>{index + 1}</td>
                      <td>
                        <img 
                          src={`/uploads/${menu.gambar.split('/').pop()}`} 
                          alt={menu.menu} 
                          style={{ width: '50px', height: '50px', objectFit: 'cover' }} 
                          className="rounded"
                        />
                      </td>
                      <td>{menu.menu}</td>
                      <td>{menu.kategori}</td>
                      <td>Rp {menu.harga.toLocaleString('id-ID')}</td>
                      <td>
                        <div className="btn-group" role="group">
                          <button 
                            className="btn btn-sm btn-warning me-1"
                            onClick={() => openEditModal(menu)}
                          >
                            <i className="bi bi-pencil"></i>
                          </button>
                          <button 
                            className="btn btn-sm btn-danger"
                            onClick={() => confirmDelete(menu)}
                          >
                            <i className="bi bi-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      </div>

      {/* Modal Tambah Menu */}
      {showAddModal && (
        <div className="modal fade show" style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Tambah Menu Baru</h5>
                <button type="button" className="btn-close" onClick={() => setShowAddModal(false)}></button>
              </div>
              <form onSubmit={handleSubmit(addMenu)}>
                <div className="modal-body">
                  <div className="mb-3">
                    <label htmlFor="menu" className="form-label">Nama Menu</label>
                    <input 
                      type="text" 
                      className={`form-control ${errors.menu ? 'is-invalid' : ''}`}
                      id="menu"
                      {...register('menu', { required: 'Nama menu harus diisi' })}
                    />
                    {errors.menu && <div className="invalid-feedback">{errors.menu.message}</div>}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="idkategori" className="form-label">Kategori</label>
                    <select 
                      className={`form-select ${errors.idkategori ? 'is-invalid' : ''}`}
                      id="idkategori"
                      {...register('idkategori', { required: 'Kategori harus dipilih' })}
                    >
                      <option value="">Pilih Kategori</option>
                      {categories.map(category => (
                        <option key={category.idkategori} value={category.idkategori}>
                          {category.kategori}
                        </option>
                      ))}
                    </select>
                    {errors.idkategori && <div className="invalid-feedback">{errors.idkategori.message}</div>}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="harga" className="form-label">Harga</label>
                    <input 
                      type="number" 
                      className={`form-control ${errors.harga ? 'is-invalid' : ''}`}
                      id="harga"
                      {...register('harga', { 
                        required: 'Harga harus diisi',
                        min: { value: 1000, message: 'Harga minimal Rp 1.000' }
                      })}
                    />
                    {errors.harga && <div className="invalid-feedback">{errors.harga.message}</div>}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="gambar" className="form-label">Gambar Menu</label>
                    <input 
                      type="file" 
                      className={`form-control ${errors.gambar ? 'is-invalid' : ''}`}
                      id="gambar"
                      accept="image/*"
                      {...register('gambar', { 
                        required: 'Gambar menu harus diupload',
                        onChange: handleImageChange
                      })}
                    />
                    {errors.gambar && <div className="invalid-feedback">{errors.gambar.message}</div>}
                  </div>
                  {imagePreview && (
                    <div className="mb-3">
                      <label className="form-label">Preview</label>
                      <div>
                        <img 
                          src={imagePreview} 
                          alt="Preview" 
                          className="img-thumbnail" 
                          style={{ maxHeight: '200px' }} 
                        />
                      </div>
                    </div>
                  )}
                </div>
                <div className="modal-footer">
                  <button type="button" className="btn btn-secondary" onClick={() => setShowAddModal(false)}>Batal</button>
                  <button type="submit" className="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}

      {/* Modal Edit Menu */}
      {showEditModal && (
        <div className="modal fade show" style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Edit Menu</h5>
                <button type="button" className="btn-close" onClick={() => setShowEditModal(false)}></button>
              </div>
              <form onSubmit={handleSubmit(updateMenu)}>
                <div className="modal-body">
                  <div className="mb-3">
                    <label htmlFor="edit-menu" className="form-label">Nama Menu</label>
                    <input 
                      type="text" 
                      className={`form-control ${errors.menu ? 'is-invalid' : ''}`}
                      id="edit-menu"
                      {...register('menu', { required: 'Nama menu harus diisi' })}
                    />
                    {errors.menu && <div className="invalid-feedback">{errors.menu.message}</div>}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="edit-idkategori" className="form-label">Kategori</label>
                    <select 
                      className={`form-select ${errors.idkategori ? 'is-invalid' : ''}`}
                      id="edit-idkategori"
                      {...register('idkategori', { required: 'Kategori harus dipilih' })}
                    >
                      <option value="">Pilih Kategori</option>
                      {categories.map(category => (
                        <option key={category.idkategori} value={category.idkategori}>
                          {category.kategori}
                        </option>
                      ))}
                    </select>
                    {errors.idkategori && <div className="invalid-feedback">{errors.idkategori.message}</div>}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="edit-harga" className="form-label">Harga</label>
                    <input 
                      type="number" 
                      className={`form-control ${errors.harga ? 'is-invalid' : ''}`}
                      id="edit-harga"
                      {...register('harga', { 
                        required: 'Harga harus diisi',
                        min: { value: 1000, message: 'Harga minimal Rp 1.000' }
                      })}
                    />
                    {errors.harga && <div className="invalid-feedback">{errors.harga.message}</div>}
                  </div>
                  <div className="mb-3">
                    <label htmlFor="edit-gambar" className="form-label">Gambar Menu (Opsional)</label>
                    <input 
                      type="file" 
                      className={`form-control ${errors.gambar ? 'is-invalid' : ''}`}
                      id="edit-gambar"
                      accept="image/*"
                      {...register('gambar', { 
                        required: false,
                        onChange: handleImageChange
                      })}
                    />
                    <small className="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                    {errors.gambar && <div className="invalid-feedback">{errors.gambar.message}</div>}
                  </div>
                  {imagePreview && (
                    <div className="mb-3">
                      <label className="form-label">Preview</label>
                      <div>
                        <img 
                          src={imagePreview} 
                          alt="Preview" 
                          className="img-thumbnail" 
                          style={{ maxHeight: '200px' }} 
                        />
                      </div>
                    </div>
                  )}
                </div>
                <div className="modal-footer">
                  <button type="button" className="btn btn-secondary" onClick={() => setShowEditModal(false)}>Batal</button>
                  <button type="submit" className="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}

      {/* Konfirmasi Hapus */}
      {showConfirm && (
        <div className="modal fade show" style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog modal-sm">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Konfirmasi Hapus</h5>
                <button type="button" className="btn-close" onClick={cancelDelete}></button>
              </div>
              <div className="modal-body">
                <p>Apakah Anda yakin ingin menghapus menu <strong>{itemToDelete?.menu}</strong>?</p>
                <p className="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>
              </div>
              <div className="modal-footer">
                <button type="button" className="btn btn-secondary" onClick={cancelDelete}>Batal</button>
                <button type="button" className="btn btn-danger" onClick={handleDelete}>Hapus</button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Menu;