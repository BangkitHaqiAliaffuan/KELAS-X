import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useForm } from 'react-hook-form';

const Kategori = () => {
  const [kategoris, setKategoris] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showModal, setShowModal] = useState(false);
  const [showEditModal, setShowEditModal] = useState(false);
  const [showDetailModal, setShowDetailModal] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [submitLoading, setSubmitLoading] = useState(false);
  const [submitError, setSubmitError] = useState(null);
  const [submitSuccess, setSubmitSuccess] = useState(false);
  const [currentKategori, setCurrentKategori] = useState(null);
  
  const { register, handleSubmit, reset, setValue, formState: { errors } } = useForm();

  // Memperbarui nilai form ketika currentKategori berubah
  useEffect(() => {
    if (currentKategori && showEditModal) {
      setValue('kategori', currentKategori.kategori);
      setValue('keterangan', currentKategori.keterangan);
      console.log('useEffect: Nilai keterangan diset ke:', currentKategori.keterangan);
    }
  }, [currentKategori, showEditModal, setValue]);

  const fetchKategoris = async () => {
    try {
      setLoading(true);
      const response = await axios.get('http://127.0.0.1:8000/api/kategoris');
      setKategoris(response.data);
      setLoading(false);
    } catch (err) {
      setError('Terjadi kesalahan saat mengambil data kategori');
      console.error('Error fetching kategoris:', err);
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchKategoris();
  }, []);
  
  const onSubmit = async (data) => {
    try {
      setSubmitLoading(true);
      setSubmitError(null);
      setSubmitSuccess(false);
      
      const response = await axios.post('http://127.0.0.1:8000/api/kategoris', data);
      
      setSubmitSuccess(true);
      setShowModal(false);
      reset();
      fetchKategoris(); // Refresh data setelah berhasil menambahkan
    } catch (err) {
      setSubmitError(err.response?.data?.message || 'Terjadi kesalahan saat menambahkan kategori');
      console.error('Error adding kategori:', err);
    } finally {
      setSubmitLoading(false);
    }
  };
  
  const handleCloseModal = () => {
    setShowModal(false);
    setSubmitError(null);
    setSubmitSuccess(false);
    reset();
  };

  const handleShowDetail = async (id) => {
    try {
      setLoading(true);
      const response = await axios.get(`http://127.0.0.1:8000/api/kategoris/${id}/edit`);
      setCurrentKategori(response.data);
      setShowDetailModal(true);
      setLoading(false);
    } catch (err) {
      setError('Terjadi kesalahan saat mengambil detail kategori');
      console.error('Error fetching kategori detail:', err);
      setLoading(false);
    }
  };

  const handleCloseDetailModal = () => {
    setShowDetailModal(false);
    setCurrentKategori(null);
  };

  const handleEdit = async (id) => {
    try {
      if (!id) {
        setError('ID kategori tidak valid');
        return;
      }
      setLoading(true);
      const response = await axios.get(`http://127.0.0.1:8000/api/kategoris/${id}/edit`);
      console.log('Data kategori dari API:', response.data);
      setCurrentKategori(response.data);
      setValue('kategori', response.data.kategori);
      setValue('keterangan', response.data.keterangan);
      console.log('Nilai keterangan yang diset:', response.data.keterangan);
      setShowEditModal(true);
      setLoading(false);
    } catch (err) {
      setError('Terjadi kesalahan saat mengambil data kategori untuk diedit');
      console.error('Error fetching kategori for edit:', err);
      setLoading(false);
    }
  };

  const handleCloseEditModal = () => {
    setShowEditModal(false);
    setSubmitError(null);
    setSubmitSuccess(false);
    setCurrentKategori(null);
    reset();
  };

  const handleUpdate = async (data) => {
    if (!currentKategori) return;
    
    try {
      setSubmitLoading(true);
      setSubmitError(null);
      setSubmitSuccess(false);
      
      // Menggunakan idkategori sesuai dengan properti di backend
      const kategoriId = currentKategori.idkategori;
      if (!kategoriId) {
        setSubmitError('ID kategori tidak valid');
        setSubmitLoading(false);
        return;
      }
      
      const response = await axios.put(`http://127.0.0.1:8000/api/kategoris/${kategoriId}`, data);
      
      setSubmitSuccess(true);
      setTimeout(() => {
        setShowEditModal(false);
        setCurrentKategori(null);
        reset();
        fetchKategoris(); // Refresh data setelah berhasil update
      }, 1500);
    } catch (err) {
      setSubmitError(err.response?.data?.message || 'Terjadi kesalahan saat memperbarui kategori');
      console.error('Error updating kategori:', err);
    } finally {
      setSubmitLoading(false);
    }
  };

  const handleShowDeleteConfirm = (kategori) => {
    setCurrentKategori(kategori);
    setShowDeleteModal(true);
  };

  const handleCloseDeleteModal = () => {
    setShowDeleteModal(false);
    setCurrentKategori(null);
  };

  const handleDelete = async () => {
    if (!currentKategori) return;
    
    try {
      setSubmitLoading(true);
      // Menggunakan idkategori sesuai dengan properti di backend
      const kategoriId = currentKategori.idkategori;
      if (!kategoriId) {
        setSubmitError('ID kategori tidak valid');
        setSubmitLoading(false);
        return;
      }
      
      await axios.delete(`http://127.0.0.1:8000/api/kategoris/${kategoriId}`);
      setShowDeleteModal(false);
      setCurrentKategori(null);
      fetchKategoris(); // Refresh data setelah berhasil menghapus
    } catch (err) {
      setSubmitError('Terjadi kesalahan saat menghapus kategori');
      console.error('Error deleting kategori:', err);
    } finally {
      setSubmitLoading(false);
    }
  };

  if (loading) {
    return <div className="d-flex justify-content-center"><div className="spinner-border" role="status"></div></div>;
  }

  if (error) {
    return <div className="alert alert-danger">{error}</div>;
  }

  return (
    <div className="kategori-page">
      <h2 className="mb-4">Kategori</h2>
      
      <div className="card">
        <div className="card-header d-flex justify-content-between align-items-center">
          <h5 className="mb-0">Daftar Kategori</h5>
          <button className="btn btn-primary btn-sm" onClick={() => setShowModal(true)}>Tambah Kategori</button>
        </div>
        <div className="card-body">
          <div className="table-responsive">
            <table className="table table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kategori</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {kategoris.length > 0 ? (
                  kategoris.map((kategori, index) => (
                    <tr key={kategori.idkategori || index}>
                      <td>{index + 1}</td>
                      <td>{kategori.kategori}</td>
                      <td>{kategori.keterangan}</td>
                      <td>
                        <button className="btn btn-info btn-sm me-2" onClick={() => handleShowDetail(kategori.idkategori)}>Detail</button>
                        <button className="btn btn-warning btn-sm me-2" onClick={() => handleEdit(kategori.idkategori)}>Edit</button>
                        <button className="btn btn-danger btn-sm" onClick={() => handleShowDeleteConfirm(kategori)}>Hapus</button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="4" className="text-center">Tidak ada data kategori</td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
      {/* Modal Tambah Kategori */}
      {showModal && (
        <div className="modal d-block" tabIndex="-1" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Tambah Kategori</h5>
                <button type="button" className="btn-close" onClick={handleCloseModal}></button>
              </div>
              <form onSubmit={handleSubmit(onSubmit)}>
                <div className="modal-body">
                  {submitError && (
                    <div className="alert alert-danger">{submitError}</div>
                  )}
                  {submitSuccess && (
                    <div className="alert alert-success">Kategori berhasil ditambahkan</div>
                  )}
                  
                  <div className="mb-3">
                    <label htmlFor="kategori" className="form-label">Nama Kategori</label>
                    <input 
                      type="text" 
                      className={`form-control ${errors.kategori ? 'is-invalid' : ''}`}
                      id="kategori"
                      {...register('kategori', { required: 'Nama kategori harus diisi' })}
                    />
                    {errors.kategori && (
                      <div className="invalid-feedback">{errors.kategori.message}</div>
                    )}
                  </div>
                  
                  <div className="mb-3">
                    <label htmlFor="keterangan" className="form-label">Keterangan</label>
                    <textarea 
                      className="form-control"
                      id="keterangan"
                      rows="3"
                      {...register('keterangan')}
                    ></textarea>
                  </div>
                </div>
                <div className="modal-footer">
                  <button type="button" className="btn btn-secondary" onClick={handleCloseModal}>Batal</button>
                  <button type="submit" className="btn btn-primary" disabled={submitLoading}>
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
      )}

      {/* Modal Detail Kategori */}
      {showDetailModal && currentKategori && (
        <div className="modal d-block" tabIndex="-1" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Detail Kategori</h5>
                <button type="button" className="btn-close" onClick={handleCloseDetailModal}></button>
              </div>
              <div className="modal-body">
                <div className="mb-3">
                  <h6>Nama Kategori:</h6>
                  <p>{currentKategori.kategori}</p>
                </div>
                <div className="mb-3">
                  <h6>Keterangan:</h6>
                  <p>{currentKategori.keterangan || '-'}</p>
                </div>
                <div className="mb-3">
                  <h6>ID:</h6>
                  <p>{currentKategori.idkategori}</p>
                </div>
              </div>
              <div className="modal-footer">
                <button type="button" className="btn btn-secondary" onClick={handleCloseDetailModal}>Tutup</button>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Modal Edit Kategori */}
      {showEditModal && currentKategori && (
        <div className="modal d-block" tabIndex="-1" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Edit Kategori</h5>
                <button type="button" className="btn-close" onClick={handleCloseEditModal}></button>
              </div>
              <form onSubmit={handleSubmit(handleUpdate)}>
                <div className="modal-body">
                  {submitError && (
                    <div className="alert alert-danger">{submitError}</div>
                  )}
                  {submitSuccess && (
                    <div className="alert alert-success">Kategori berhasil diperbarui</div>
                  )}
                  
                  <div className="mb-3">
                    <label htmlFor="kategori" className="form-label">Nama Kategori</label>
                    <input 
                      type="text" 
                      className={`form-control ${errors.kategori ? 'is-invalid' : ''}`}
                      id="kategori"
                      {...register('kategori', { required: 'Nama kategori harus diisi' })}
                    />
                    {errors.kategori && (
                      <div className="invalid-feedback">{errors.kategori.message}</div>
                    )}
                  </div>
                  
                  <div className="mb-3">
                    <label htmlFor="keterangan" className="form-label">Keterangan</label>
                    <textarea 
                      className="form-control"
                      id="keterangan"
                      rows="3"
                      defaultValue={currentKategori.keterangan}
                      {...register('keterangan')}
                    ></textarea>
                  </div>
                </div>
                <div className="modal-footer">
                  <button type="button" className="btn btn-secondary" onClick={handleCloseEditModal}>Batal</button>
                  <button type="submit" className="btn btn-primary" disabled={submitLoading}>
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
      )}

      {/* Modal Konfirmasi Hapus */}
      {showDeleteModal && currentKategori && (
        <div className="modal d-block" tabIndex="-1" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Konfirmasi Hapus</h5>
                <button type="button" className="btn-close" onClick={handleCloseDeleteModal}></button>
              </div>
              <div className="modal-body">
                <p>Apakah Anda yakin ingin menghapus kategori <strong>{currentKategori.kategori}</strong>?</p>
                <p className="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
              </div>
              <div className="modal-footer">
                <button type="button" className="btn btn-secondary" onClick={handleCloseDeleteModal}>Batal</button>
                <button type="button" className="btn btn-danger" onClick={handleDelete} disabled={submitLoading}>
                  {submitLoading ? (
                    <>
                      <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                      Menghapus...
                    </>
                  ) : 'Hapus'}
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Kategori;