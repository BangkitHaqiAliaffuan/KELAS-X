import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import Modal from 'react-modal';

// Set appElement untuk aksesibilitas
Modal.setAppElement('#root');

// Tambahkan CSS untuk modal
const modalStyles = {
  content: {
    top: '50%',
    left: '50%',
    right: 'auto',
    bottom: 'auto',
    marginRight: '-50%',
    transform: 'translate(-50%, -50%)',
    backgroundColor: '#fff',
    padding: '0',
    border: 'none',
    borderRadius: '10px',
    boxShadow: '0 10px 25px rgba(0, 0, 0, 0.5)',
    maxWidth: '500px',
    width: '100%',
    maxHeight: '90vh',
    overflow: 'hidden'
  },
  overlay: {
    backgroundColor: 'rgba(0, 0, 0, 0.75)',
    zIndex: 1050
  }
};

// Styling untuk elemen-elemen dalam modal
const modalContentStyles = {
  header: {
    padding: '15px 20px',
    backgroundColor: '#0d6efd',
    color: 'white',
    borderBottom: '1px solid #0a58ca',
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    borderTopLeftRadius: '10px',
    borderTopRightRadius: '10px'
  },
  title: {
    margin: 0,
    fontSize: '18px',
    fontWeight: '600',
    display: 'flex',
    alignItems: 'center',
    gap: '8px'
  },
  body: {
    padding: '20px',
    backgroundColor: '#fff'
  },
  infoCard: {
    backgroundColor: '#f8f9fa',
    borderRadius: '8px',
    padding: '15px',
    marginBottom: '20px',
    border: '1px solid #e9ecef'
  },
  formGroup: {
    marginBottom: '20px'
  },
  label: {
    fontWeight: '600',
    marginBottom: '8px',
    display: 'flex',
    alignItems: 'center',
    gap: '8px',
    fontSize: '15px'
  },
  input: {
    backgroundColor: '#fff',
    border: '1px solid #ced4da',
    borderRadius: '6px',
    padding: '10px 15px',
    width: '100%',
    fontSize: '16px'
  },
  footer: {
    padding: '15px 20px',
    backgroundColor: '#f8f9fa',
    borderTop: '1px solid #e9ecef',
    display: 'flex',
    justifyContent: 'flex-end',
    gap: '10px',
    borderBottomLeftRadius: '10px',
    borderBottomRightRadius: '10px'
  },
  button: {
    padding: '10px 20px',
    borderRadius: '6px',
    fontWeight: '500',
    display: 'flex',
    alignItems: 'center',
    gap: '8px',
    border: 'none',
    cursor: 'pointer',
    fontSize: '15px'
  },
  cancelBtn: {
    backgroundColor: '#6c757d',
    color: 'white'
  },
  confirmBtn: {
    backgroundColor: '#0d6efd',
    color: 'white' 
  },
  alert: {
    padding: '15px',
    borderRadius: '6px',
    display: 'flex',
    alignItems: 'center',
    gap: '10px',
    backgroundColor: '#cff4fc',
    border: '1px solid #b6effb',
    color: '#055160'
  }
};

const Order = () => {
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showPaymentModal, setShowPaymentModal] = useState(false);
  const [selectedOrder, setSelectedOrder] = useState(null);
  const [paymentAmount, setPaymentAmount] = useState('');
  const [paymentStatus, setPaymentStatus] = useState(1); // Default status: 1 (Lunas)
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');

  // Fetch orders data
  const fetchOrders = async () => {
    try {
      setLoading(true);
      let url = 'http://localhost:8000/api/orders';
      
      // Add date filter if provided
      if (startDate && endDate) {
        url += `?start_date=${startDate}&end_date=${endDate}`;
      }
      
      const response = await axios.get(url);
      if (response.data.status) {
        setOrders(response.data.data);
      } else {
        setError('Gagal memuat data order');
      }
    } catch (err) {
      setError('Terjadi kesalahan saat memuat data');
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchOrders();
  }, []);

  // Handle payment modal
  const openPaymentModal = (order) => {
    setSelectedOrder(order);
    setPaymentAmount(order.total.toString());
    setShowPaymentModal(true);
  };

  const closePaymentModal = () => {
    setShowPaymentModal(false);
    setSelectedOrder(null);
    setPaymentAmount('');
  };

  // Process payment
  const handlePayment = async () => {
    if (!selectedOrder || !paymentAmount) return;

    try {
      const response = await axios.put(`http://localhost:8000/api/orders/${selectedOrder.idorder}/payment`, {
        bayar: parseFloat(paymentAmount),
        status: paymentStatus
      });

      if (response.data.status) {
        // Update the order in the list
        setOrders(orders.map(order => 
          order.idorder === selectedOrder.idorder ? response.data.data : order
        ));
        closePaymentModal();
        alert('Pembayaran berhasil!');
      } else {
        alert('Gagal melakukan pembayaran');
      }
    } catch (err) {
      console.error(err);
      alert('Terjadi kesalahan saat memproses pembayaran');
    }
  };

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

  return (
    <div className="order-page">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Order</h2>
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
          <button 
            className="btn btn-primary" 
            onClick={() => fetchOrders()}
          >
            Filter
          </button>
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
      ) : (
        <div className="card">
          <div className="card-body">
            <div className="table-responsive">
              <table className="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>ID Order</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  {orders.length > 0 ? (
                    orders.map((order) => (
                      <tr key={order.idorder}>
                        <td>{order.idorder}</td>
                        <td>{order.pelanggan ? order.pelanggan.pelanggan : 'N/A'}</td>
                        <td>{new Date(order.tglorder).toLocaleDateString('id-ID')}</td>
                        <td>{formatCurrency(order.total)}</td>
                        <td>{order.bayar ? formatCurrency(order.bayar) : '-'}</td>
                        <td>{order.kembali ? formatCurrency(order.kembali) : '-'}</td>
                        <td>
                          <span className={`badge ${parseInt(order.status) === 1 ? 'bg-success' : 'bg-warning'}`}>
                            {getStatusText(order.status)}
                          </span>
                        </td>
                        <td>
                          <div className="btn-group" role="group">
                            <Link to={`/order-detail/${order.idorder}`} className="btn btn-sm btn-info">
                              <i className="bi bi-eye"></i> Detail
                            </Link>
                            {parseInt(order.status) === 0 && (
                              <button 
                                className="btn btn-sm btn-success ms-1" 
                                onClick={() => openPaymentModal(order)}
                              >
                                <i className="bi bi-cash"></i> Bayar
                              </button>
                            )}
                          </div>
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan="8" className="text-center">Tidak ada data order</td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      )}

      {/* Payment Modal menggunakan react-modal */}
      {/* Payment Modal dengan styling yang telah didefinisikan di luar komponen */}
      <Modal
        isOpen={showPaymentModal && selectedOrder !== null}
        onRequestClose={closePaymentModal}
        contentLabel="Modal Pembayaran"
        style={modalStyles}
        shouldCloseOnOverlayClick={true}
      >
        {selectedOrder && (
          <div className="modal-content" style={{backgroundColor: '#fff', width: '100%'}}>
            {/* Header Modal */}
            <div style={modalContentStyles.header}>
              <h5 style={modalContentStyles.title}>
                <i className="bi bi-credit-card"></i>
                Pembayaran Order #{selectedOrder.idorder}
              </h5>
              <button type="button" className="btn-close btn-close-white" onClick={closePaymentModal}></button>
            </div>
            
            {/* Body Modal */}
            <div style={modalContentStyles.body}>
              {/* Informasi Pelanggan dan Total */}
              <div style={modalContentStyles.infoCard}>
                <div className="row">
                  <div className="col-md-6">
                    <p style={{fontWeight: '600', marginBottom: '8px', display: 'flex', alignItems: 'center', gap: '8px'}}>
                      <i className="bi bi-person"></i>
                      Pelanggan:
                    </p>
                    <p style={{marginLeft: '24px', marginBottom: '0'}}>
                      {selectedOrder.pelanggan ? selectedOrder.pelanggan.pelanggan : 'N/A'}
                    </p>
                  </div>
                  <div className="col-md-6">
                    <p style={{fontWeight: '600', marginBottom: '8px', display: 'flex', alignItems: 'center', gap: '8px'}}>
                      <i className="bi bi-cash"></i>
                      Total:
                    </p>
                    <p style={{marginLeft: '24px', marginBottom: '0', fontWeight: '700', color: '#0d6efd', fontSize: '18px'}}>
                      {formatCurrency(selectedOrder.total)}
                    </p>
                  </div>
                </div>
              </div>
              
              {/* Form Pembayaran */}
              <div style={modalContentStyles.formGroup}>
                <label htmlFor="paymentAmount" style={modalContentStyles.label}>
                  <i className="bi bi-wallet2"></i>
                  Jumlah Bayar
                </label>
                <div className="input-group">
                  <span className="input-group-text" style={{backgroundColor: '#f8f9fa', borderRight: 'none'}}>Rp</span>
                  <input 
                    type="number" 
                    className="form-control form-control-lg" 
                    style={{
                      backgroundColor: '#fff',
                      borderLeft: 'none',
                      boxShadow: 'none',
                      fontSize: '16px',
                      height: '48px',
                      fontWeight: '500'
                    }}
                    id="paymentAmount"
                    value={paymentAmount}
                    onChange={(e) => setPaymentAmount(e.target.value)}
                    placeholder="Masukkan jumlah pembayaran"
                  />
                </div>
              </div>
              
              {/* Status Pembayaran */}
              <div style={modalContentStyles.formGroup}>
                <label htmlFor="paymentStatus" style={modalContentStyles.label}>
                  <i className="bi bi-check-circle"></i>
                  Status Pembayaran
                </label>
                <select 
                  style={{
                    backgroundColor: '#fff',
                    border: '1px solid #ced4da',
                    borderRadius: '6px',
                    padding: '10px 15px',
                    width: '100%',
                    height: '48px',
                    fontSize: '16px',
                    fontWeight: '500'
                  }}
                  id="paymentStatus"
                  value={paymentStatus}
                  onChange={(e) => setPaymentStatus(parseInt(e.target.value))}
                >
                  <option value="1">Lunas</option>
                  <option value="0">Belum Lunas</option>
                </select>
              </div>
              
              {/* Info Kembalian */}
              {paymentAmount && selectedOrder.total && (
                <div style={modalContentStyles.alert}>
                  <i className="bi bi-info-circle-fill" style={{fontSize: '18px'}}></i>
                  <div>
                    <strong>Kembalian:</strong> {formatCurrency(parseFloat(paymentAmount) - selectedOrder.total)}
                  </div>
                </div>
              )}
            </div>
            
            {/* Footer Modal */}
            <div style={modalContentStyles.footer}>
              <button 
                type="button" 
                style={{...modalContentStyles.button, ...modalContentStyles.cancelBtn}}
                onClick={closePaymentModal}
              >
                <i className="bi bi-x-circle"></i>
                Batal
              </button>
              <button 
                type="button" 
                style={{...modalContentStyles.button, ...modalContentStyles.confirmBtn}}
                onClick={handlePayment}
              >
                <i className="bi bi-check-circle"></i>
                Proses Pembayaran
              </button>
            </div>
          </div>
        )}
      </Modal>
    </div>
  );
};

export default Order;