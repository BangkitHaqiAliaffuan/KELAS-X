import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

const AllOrderDetails = () => {
  const [orderDetails, setOrderDetails] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');
  const [controller, setController] = useState(null);
  const [timeoutId, setTimeoutId] = useState(null);

  const fetchAllOrderDetails = async () => {
    try {
      setLoading(true);
      setError(null);
      
      const newController = new AbortController();
      setController(newController);
      
      const newTimeoutId = setTimeout(() => {
        newController.abort();
        setError('Permintaan dibatalkan karena timeout');
        setLoading(false);
      }, 10000);
      setTimeoutId(newTimeoutId);
      
      // Pastikan URL lengkap dengan base URL
      let url = 'http://localhost:8000/api/order-details';
      if (startDate && endDate) {
        url += `?start_date=${startDate}&end_date=${endDate}`;
      }
      
      const response = await axios.get(url, {
        signal: newController.signal
      });
      
      console.log('Response from API:', response.data); // Tambahkan log untuk debugging
      
      clearTimeout(newTimeoutId);
      if (response.data && response.data.data) {
        setOrderDetails(response.data.data);
      } else {
        console.error('Invalid response format:', response.data);
        setOrderDetails([]);
      }
    } catch (err) {
      console.error('Full error object:', err); // Tambahkan log untuk error
      if (err.name === 'AbortError') {
        setError('Permintaan dibatalkan karena timeout');
      } else if (err.response) {
        setError(err.response.data?.message || 'Terjadi kesalahan pada server');
      } else if (err.request) {
        setError('Tidak dapat terhubung ke server. Periksa koneksi Anda.');
      } else {
        setError('Terjadi kesalahan saat memuat data');
      }
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchAllOrderDetails();

    return () => {
      if (timeoutId) clearTimeout(timeoutId);
      if (controller) controller.abort();
    };
  }, []);

  // Format currency
  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(amount);
  };

  // Format date
  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('id-ID');
  };

  return (
    <div className="all-order-details-page">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Semua Detail Order</h2>
        <div className="d-flex gap-2 align-items-center">
          <div>
            <label className="form-label">Tanggal Mulai</label>
            <input 
              type="date" 
              className="form-control" 
              value={startDate}
              onChange={(e) => setStartDate(e.target.value)}
            />
          </div>
          <div>
            <label className="form-label">Tanggal Akhir</label>
            <input 
              type="date" 
              className="form-control" 
              value={endDate}
              onChange={(e) => setEndDate(e.target.value)}
            />
          </div>
          <div className="mb-3">
            <button 
              className="btn btn-primary" 
              onClick={fetchAllOrderDetails}
            >
              Filter
            </button>
          </div>
          <Link to="/order" className="btn btn-secondary">
            <i className="bi bi-arrow-left"></i> Kembali
          </Link>
        </div>
      </div>

      {loading ? (
        <div className="text-center">
          <div className="spinner-border" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      ) : error ? (
        <div className="alert alert-danger">{error}</div>
      ) : orderDetails.length === 0 ? (
        <div className="alert alert-warning">Data tidak ditemukan</div>
      ) : (
        <div className="card">
          <div className="card-header bg-info text-white">
            <h5 className="mb-0">Semua Detail Order</h5>
          </div>
          <div className="card-body">
            <div className="table-responsive">
              <table className="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>ID Detail</th>
                    <th>ID Order</th>
                    <th>Pelanggan</th>
                    <th>Tanggal Order</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    
                  </tr>
                </thead>
                <tbody>
                  {orderDetails.map((detail) => (
                    <tr key={detail.idorderdetail}>
                      <td>{detail.idorderdetail}</td>
                      <td>{detail.idorder}</td>
                      <td>{detail.order?.pelanggan?.pelanggan || 'N/A'}</td>
                      <td>{detail.order ? formatDate(detail.order.tglorder) : 'N/A'}</td>
                      <td>{detail.menu?.menu || 'N/A'}</td>
                      <td>{formatCurrency(detail.hargajual)}</td>
                      <td>{detail.jumlah}</td>
                      <td>{formatCurrency(detail.jumlah * detail.hargajual)}</td>
             
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default AllOrderDetails;