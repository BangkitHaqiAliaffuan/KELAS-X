import React, { createContext, useContext, useState, useEffect } from 'react';
import axios from 'axios';

const AuthContext = createContext();

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [loading, setLoading] = useState(true);

  // Set up axios interceptor for authentication
  useEffect(() => {
    const token = localStorage.getItem('token');
    
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }

    return () => {
      delete axios.defaults.headers.common['Authorization'];
    };
  }, []);

  // Initialize user from localStorage
  useEffect(() => {
    const token = localStorage.getItem('token');
    const savedUser = localStorage.getItem('user');

    if (token && savedUser) {
      const userData = JSON.parse(savedUser);
      setUser(userData);
      setIsAuthenticated(true);
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }

    setLoading(false);
  }, []);

  const loginCustomer = async (email, password) => {
    try {
      const response = await axios.post('http://localhost:8000/api/pelanggan/login', {
        email,
        password
      });

      if (response.data.status === 'success') {
        const customerData = response.data.data;
        const userData = {
          ...customerData,
          name: customerData.pelanggan,
          level: 'customer',
          id: customerData.idpelanggan || customerData.id, // Ensure we get the ID from either field
          idpelanggan: customerData.idpelanggan || customerData.id, // Store both formats for compatibility
          api_token: customerData.api_token
        };

        setUser(userData);
        setIsAuthenticated(true);
        localStorage.setItem('token', userData.api_token);
        localStorage.setItem('user', JSON.stringify(userData));
        return { success: true, user: userData };
      }

      return { success: false, message: response.data.message };
    } catch (error) {
      console.error('Customer login error:', error);
      return {
        success: false,
        message: error.response?.data?.message || 'Login failed. Please try again.'
      };
    }
  };

  const loginStaff = async (email, password) => {
    try {
      const response = await axios.post('http://localhost:8000/api/login', {
        email,
        password
      });

      if (response.data.status) {
        const userData = response.data.data;
        setUser(userData);
        setIsAuthenticated(true);
        localStorage.setItem('token', userData.api_token);
        localStorage.setItem('user', JSON.stringify(userData));
        return { success: true, user: userData };
      }
      return { success: false, message: response.data.message };
    } catch (error) {
      console.error('Staff login error:', error);
      return {
        success: false,
        message: error.response?.data?.message || 'Login failed. Please try again.'
      };
    }
  };

  const logout = async () => {
    try {
      const token = localStorage.getItem('token');
      if (!token) return;

      if (user?.level === 'customer') {
        // Customer logout
        await axios.post('http://localhost:8000/api/pelanggan/logout', {}, {
          headers: { 'Authorization': token }
        });
      } else {
        // Staff logout
        await axios.put(`http://localhost:8000/api/users/${user.id}/logout`, {}, {
          headers: { 'Authorization': `Bearer ${token}` }
        });
      }
    } catch (error) {
      console.error('Logout error:', error);
    } finally {
      setUser(null);
      setIsAuthenticated(false);
      localStorage.removeItem('token');
      localStorage.removeItem('user');
    }
  };

  const registerCustomer = async (customerData) => {
    try {
      const response = await axios.post('http://localhost:8000/api/pelanggan/register', customerData);

      if (response.data.status === 'success') {
        return { success: true, message: 'Registration successful!' };
      }
      return { success: false, message: response.data.message };
    } catch (error) {
      console.error('Customer registration error:', error);
      return {
        success: false,
        message: error.response?.data?.message || 'Registration failed. Please try again.'
      };
    }
  };

  const value = {
    user,
    isAuthenticated,
    loginCustomer,
    loginStaff,
    logout,
    registerCustomer,
    loading
  };

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <AuthContext.Provider value={value}>
      {children}
    </AuthContext.Provider>
  );
};