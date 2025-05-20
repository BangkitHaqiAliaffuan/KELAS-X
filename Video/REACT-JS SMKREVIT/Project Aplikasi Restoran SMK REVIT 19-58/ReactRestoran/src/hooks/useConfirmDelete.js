import { useState } from 'react';

/**
 * Custom hook untuk menangani konfirmasi penghapusan item
 * @param {Function} deleteCallback - Fungsi yang akan dipanggil jika pengguna mengkonfirmasi penghapusan
 * @returns {Object} - Object berisi state dan fungsi untuk menangani konfirmasi
 */
const useConfirmDelete = (deleteCallback) => {
  const [itemToDelete, setItemToDelete] = useState(null);
  const [showConfirm, setShowConfirm] = useState(false);

  // Fungsi untuk menampilkan konfirmasi
  const confirmDelete = (item) => {
    setItemToDelete(item);
    setShowConfirm(true);
  };

  // Fungsi untuk membatalkan penghapusan
  const cancelDelete = () => {
    setShowConfirm(false);
    setItemToDelete(null);
  };

  // Fungsi untuk mengkonfirmasi dan menjalankan penghapusan
  const handleDelete = () => {
    if (itemToDelete && deleteCallback) {
      deleteCallback(itemToDelete);
    }
    setShowConfirm(false);
    setItemToDelete(null);
  };

  return {
    itemToDelete,
    showConfirm,
    confirmDelete,
    cancelDelete,
    handleDelete
  };
};

export default useConfirmDelete;