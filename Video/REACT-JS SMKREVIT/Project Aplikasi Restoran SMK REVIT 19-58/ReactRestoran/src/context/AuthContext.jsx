import React, { createContext, useState, useEffect, useContext } from 'react';
import axios from 'axios';

// Membuat context untuk autentikasi
const AuthContext = createContext(null);

// Provider untuk AuthContext
export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Cek status autentikasi saat aplikasi dimuat
  useEffect(() => {
    const checkAuth = async () => {
      try {
        const token = localStorage.getItem('adminToken');
        const storedUser = localStorage.getItem('adminUser');
        
        if (token && storedUser) {
          // Set token untuk semua request axios
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
          setUser(JSON.parse(storedUser));
        }
      } catch (err) {
        console.error('Error checking auth:', err);
        setError('Terjadi kesalahan saat memeriksa autentikasi');
      } finally {
        setLoading(false);
      }
    };

    checkAuth();
  }, []);

  // Fungsi untuk login
  const login = async (email, password) => {
    try {
      setLoading(true);
      setError(null);

      const response = await axios.post('http://localhost:8000/api/login', {
        email,
        password
      });

      const { token, user } = response.data;
      
      // Simpan token dan data user
      localStorage.setItem('adminToken', token);
      localStorage.setItem('adminUser', JSON.stringify(user));
      
      // Set default header untuk axios
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      
      // Update state
      setUser(user);
      
      return { success: true, user };
    } catch (err) {
      const errorMessage = err.response?.data?.message || 'Terjadi kesalahan saat login';
      setError(errorMessage);
      return { success: false, error: errorMessage };
    } finally {
      setLoading(false);
    }
  };

  // Fungsi untuk logout
  const logout = async () => {
    try {
      setLoading(true);
      
      if (user && user.id) {
        // Ambil token dari localStorage
        const token = localStorage.getItem('adminToken');
        
        // Buat konfigurasi header dengan token
        const config = {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        };
        
        await axios.put(`http://localhost:8000/api/users/${user.id}/logout`, {}, config);
      }
    } catch (err) {
      console.error('Error logout:', err);
    } finally {
      // Hapus token dan data user dari localStorage
      localStorage.removeItem('adminToken');
      localStorage.removeItem('adminUser');
      
      // Hapus header Authorization dari axios
      delete axios.defaults.headers.common['Authorization'];
      
      // Reset state
      setUser(null);
      setLoading(false);
    }
  };

  // Fungsi untuk cek apakah user memiliki akses ke halaman tertentu
  const hasAccess = (requiredLevels) => {
    if (!user) return false;
    return requiredLevels.includes(user.level);
  };

  // Nilai yang akan disediakan oleh context
  const value = {
    user,
    loading,
    error,
    login,
    logout,
    hasAccess,
    isAuthenticated: !!user
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};

// Custom hook untuk menggunakan AuthContext
export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth harus digunakan di dalam AuthProvider');
  }
  return context;
};

export default AuthContext;