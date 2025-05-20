import "bootstrap/dist/css/bootstrap.min.css";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import { useState, useEffect } from "react";
import axios from "axios";

// Components
import Navbar from "./components/Navbar";
import Sidebar from "./components/Sidebar";
import Footer from "./components/Footer";
import ProtectedRoute from "./components/ProtectedRoute";

// Context
import { AuthProvider, useAuth } from "./context/AuthContext";

// Pages
import Kategori from "./pages/Kategori";
import Menu from "./pages/Menu";
import Pelanggan from "./pages/Pelanggan";
import Order from "./pages/Order";
import OrderDetail from "./pages/OrderDetail";
import AllOrderDetails from "./pages/AllOrderDetails";
import Admin from "./pages/Admin";
import Login from "./pages/Login";

function AppContent() {
  const { user, isAuthenticated } = useAuth();

  // Fungsi untuk menentukan halaman redirect berdasarkan level user
  const getRedirectPage = () => {
    if (!user) return "/login";
    
    switch (user.level) {
      case 'admin':
        return "/admin";
      case 'kasir':
        return "/order";
      case 'koki':
        return "/allorderdetails";
      default:
        return "/login";
    }
  };

  return (
    <div className="d-flex flex-column min-vh-100">
      {isAuthenticated && <Navbar />}
      <div className="container-fluid flex-grow-1">
        <div className="row">
          {isAuthenticated && (
            <div className="col-md-2 bg-light">
              <Sidebar />
            </div>
          )}
          <div className={isAuthenticated ? "col-md-10 py-3" : "col-12 py-3"}>
            <Routes>
              {/* Rute publik */}
              <Route path="/login" element={isAuthenticated ? <Navigate to={getRedirectPage()} /> : <Login />} />
              
              {/* Rute yang memerlukan autentikasi */}
              <Route path="/" element={<Navigate to={isAuthenticated ? getRedirectPage() : "/login"} />} />
              
              {/* Rute untuk Admin */}
              <Route path="/admin" element={<ProtectedRoute element={<Admin />} requiredLevels={['admin']} />} />
              <Route path="/kategori" element={<ProtectedRoute element={<Kategori />} requiredLevels={['admin']} />} />
              <Route path="/menu" element={<ProtectedRoute element={<Menu />} requiredLevels={['admin']} />} />
              <Route path="/pelanggan" element={<ProtectedRoute element={<Pelanggan />} requiredLevels={['admin']} />} />
              
              {/* Rute untuk Admin dan Kasir */}
              <Route path="/order" element={<ProtectedRoute element={<Order />} requiredLevels={['admin', 'kasir']} />} />
              <Route path="/orderdetail" element={<ProtectedRoute element={<OrderDetail />} requiredLevels={['admin', 'kasir']} />} />
              
              {/* Rute untuk Admin, Kasir, dan Koki */}
              <Route path="/allorderdetails" element={<ProtectedRoute element={<AllOrderDetails />} requiredLevels={['admin', 'kasir', 'koki']} />} />
            </Routes>
          </div>
        </div>
      </div>
      {isAuthenticated && <Footer />}
    </div>
  );
}

function App() {
  return (
    <Router>
      <AuthProvider>
        <AppContent />
      </AuthProvider>
    </Router>
  );
}

export default App;
