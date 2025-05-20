import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';

const OrderDetail = () => {
  const { id } = useParams();
  const [order, setOrder] = useState(null);
  const [orderDetails, setOrderDetails] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => {
      controller.abort();
      setError('Waktu permintaan habis. Silakan coba lagi.');
      setLoading(false);
    }, 10000); // Timeout setelah 10 detik

    const fetchOrderDetails = async () => {
      try {
        setLoading(true);
        setError(null); // Reset error sebelum fetch

        if (!id) {
          setError('ID order tidak valid');
          return;
        }

        const response = await axios.get(
          `http://localhost:8000/api/order-details/order/${id}`,
          { signal: controller.signal }
        );
        
        if (response.data.status) {
          if (!response.data.order) {
            setError('Order tidak ditemukan');
            return;
          }
          setOrder(response.data.order);
          setOrderDetails(response.data.details || []);
        } else {
          setError(response.data.message || 'Gagal memuat data detail order');
        }
      } catch (err) {
        if (err.name === 'AbortError') {
          setError('Permintaan dibatalkan karena timeout');
        } else if (err.response) {
          setError(err.response.data?.message || 'Terjadi kesalahan pada server');
        } else if (err.request) {
          setError('Tidak dapat terhubung ke server. Periksa koneksi Anda.');
        } else {
          setError('Terjadi kesalahan saat memuat data');
        }
        console.error('Error fetching order details:', err);
      } finally {
        setLoading(false);
      }
    };

    if (id) {
      fetchOrderDetails();
    } else {
      setError('ID order tidak ditemukan');
      setLoading(false);
    }

    return () => {
      clearTimeout(timeoutId);
      controller.abort();
    };
  }, [id]);

  // Format currency
  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(amount);
  };

  // Get status text
  const getStatusText = (status) => {
    switch (parseInt(status)) {
      case 0: return 'Belum Bayar';
      case 1: return 'Lunas';
      default: return 'Unknown';
    }
  };

  // Calculate total
  const calculateTotal = () => {
    if (!orderDetails || orderDetails.length === 0) return 0;
    return orderDetails.reduce((total, item) => total + (item.jumlah * item.hargajual), 0);
  };

  return (
    <div className="order-detail-page">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Order</h2>
        <Link to="/order" className="btn btn-secondary">
          <i className="bi bi-arrow-left"></i> Kembali ke Daftar Order
        </Link>
      </div>

      {loading ? (
        <div className="text-center">
          <div className="spinner-border" role="status">
            <span className="visually-hidden">Loading...</span>
          </div>
        </div>
      ) : error ? (
        <div className="alert alert-danger">{error}</div>
      ) : !order ? (
        <div className="alert alert-warning">Order tidak ditemukan</div>
      ) : (
        <>
          {/* Order Information */}
          <div className="card mb-4">
            <div className="card-header bg-primary text-white">
              <h5 className="mb-0">Informasi Order #{order.idorder}</h5>
            </div>
            <div className="card-body">
              <div className="row">
                <div className="col-md-6">
                  <p><strong>Pelanggan:</strong> {order.pelanggan ? order.pelanggan.pelanggan : 'N/A'}</p>
                  <p><strong>Tanggal Order:</strong> {new Date(order.tglorder).toLocaleDateString('id-ID')}</p>
                </div>
                <div className="col-md-6">
                  <p>
                    <strong>Status Pembayaran:</strong> 
                    <span className={`badge ms-2 ${parseInt(order.status) === 1 ? 'bg-success' : 'bg-warning'}`}>
                      {getStatusText(order.status)}
                    </span>
                  </p>
                  <p><strong>Total:</strong> {formatCurrency(order.total)}</p>
                  {order.bayar > 0 && (
                    <>
                      <p><strong>Bayar:</strong> {formatCurrency(order.bayar)}</p>
                      <p><strong>Kembali:</strong> {formatCurrency(order.kembali)}</p>
                    </>
                  )}
                </div>
              </div>
            </div>
          </div>

          {/* Order Details */}
          <div className="card">
            <div className="card-header bg-info text-white">
              <h5 className="mb-0">Detail Item</h5>
            </div>
            <div className="card-body">
              <div className="table-responsive">
                <table className="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Menu</th>
                      <th>Harga</th>
                      <th>Jumlah</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    {orderDetails.length > 0 ? (
                      orderDetails.map((detail, index) => (
                        <tr key={detail.idorderdetail}>
                          <td>{index + 1}</td>
                          <td>{detail.menu ? detail.menu.menu : 'N/A'}</td>
                          <td>{formatCurrency(detail.hargajual)}</td>
                          <td>{detail.jumlah}</td>
                          <td>{formatCurrency(detail.jumlah * detail.hargajual)}</td>
                        </tr>
                      ))
                    ) : (
                      <tr>
                        <td colSpan="5" className="text-center">Tidak ada detail item</td>
                      </tr>
                    )}
                  </tbody>
                  <tfoot>
                    <tr className="table-dark">
                      <td colSpan="4" className="text-end"><strong>Total</strong></td>
                      <td><strong>{formatCurrency(calculateTotal())}</strong></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </>
      )}
    </div>
  );
};

export default OrderDetail;