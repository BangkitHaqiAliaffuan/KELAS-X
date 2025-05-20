import React from 'react';
import { Navigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

// Komponen untuk melindungi rute berdasarkan autentikasi dan level akses
const ProtectedRoute = ({ element, requiredLevels = [] }) => {
  const { isAuthenticated, user, hasAccess } = useAuth();

  // Jika user belum login, redirect ke halaman login
  if (!isAuthenticated) {
    return <Navigate to="/login" replace />;
  }

  // Jika requiredLevels kosong, berarti hanya perlu login tanpa cek level
  if (requiredLevels.length === 0) {
    return element;
  }

  // Jika user sudah login tapi tidak memiliki level akses yang diperlukan
  if (!hasAccess(requiredLevels)) {
    // Redirect ke halaman yang sesuai dengan level user
    if (user.level === 'admin') {
      return <Navigate to="/admin" replace />;
    } else if (user.level === 'kasir') {
      return <Navigate to="/order" replace />;
    } else if (user.level === 'koki') {
      return <Navigate to="/allorderdetails" replace />;
    } else {
      // Fallback ke halaman login jika level tidak dikenali
      return <Navigate to="/login" replace />;
    }
  }

  // Jika user memiliki akses yang diperlukan, tampilkan halaman
  return element;
};

export default ProtectedRoute;