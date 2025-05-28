import "bootstrap/dist/css/bootstrap.min.css";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import { AuthProvider, useAuth } from "./context/AuthContext";
import { CartProvider } from "./context/CartContext";
import "./index.css";
// Components
import Navbar from "./components/Navbar";
import CustomerNavbar from "./components/CustomerNavbar";
import Sidebar from "./components/Sidebar";
import Footer from "./components/Footer";
import CustomerFooter from "./components/CustomerFooter";
import ProtectedRoute from "./components/ProtectedRoute";

// Pages
import Kategori from "./pages/Kategori";
import Menu from "./pages/Menu";
import Pelanggan from "./pages/Pelanggan";
import Order from "./pages/Order";
import OrderDetail from "./pages/OrderDetail";
import AllOrderDetails from "./pages/AllOrderDetails";
import Admin from "./pages/Admin";
import StaffLogin from "./pages/StaffLogin";
import CustomerLogin from "./pages/CustomerLogin";
import CustomerRegister from "./pages/CustomerRegister";
import CustomerMenu from "./pages/CustomerMenu";
import Cart from "./pages/Cart";
import OrderHistory from "./pages/OrderHistory";
import CustomerHome from "./pages/CustomerHome";

// Wrap entire app content with providers
const App = () => {
  return (
    <Router>
      <AuthProvider>
        <CartProvider>
          <AppContent />
        </CartProvider>
      </AuthProvider>
    </Router>
  );
};

// AppContent component that handles layout and routing
const AppContent = () => {
  const { user, isAuthenticated } = useAuth();

  // Fungsi untuk menentukan halaman redirect berdasarkan level user
  const getRedirectPage = () => {
    if (!user) return "/menu";
    
    switch (user.level) {
      case 'admin':
        return "/admin";
      case 'kasir':
        return "/order";
      case 'koki':
        return "/allorderdetails";
      case 'customer':
        return "/menu";
      default:
        return "/menu";
    }
  };

  // Public routes that don't need authentication
  const publicRoutes = (
    <>
      <Route path="/" element={<CustomerHome/>} />
      <Route path="/login" element={<StaffLogin />} />
      <Route path="/customer-login" element={<CustomerLogin />} />
      <Route path="/customer-register" element={<CustomerRegister />} />
      <Route path="/menu" element={<CustomerMenu />} />
    </>
  );

  // Customer routes
  const customerRoutes = (
    <>
      <Route path="/cart" element={<Cart />} />
      <Route
        path="/order-history"
        element={
          <ProtectedRoute allowedRoles={['customer']}>
            <OrderHistory />
          </ProtectedRoute>
        }
      />
    </>
  );

  // Admin/Staff routes
  const adminRoutes = (
    <>
      <Route
        path="/admin"
        element={
          <ProtectedRoute allowedRoles={['admin']}>
            <Admin />
          </ProtectedRoute>
        }
      />
      <Route
        path="/kategoris"
        element={
          <ProtectedRoute allowedRoles={['admin']}>
            <Kategori />
          </ProtectedRoute>
        }
      />
      <Route
        path="/menus"
        element={
          <ProtectedRoute allowedRoles={['admin']}>
            <Menu />
          </ProtectedRoute>
        }
      />
      <Route
        path="/pelanggans"
        element={
          <ProtectedRoute allowedRoles={['admin', 'kasir']}>
            <Pelanggan />
          </ProtectedRoute>
        }
      />
      <Route
        path="/order"
        element={
          <ProtectedRoute allowedRoles={['admin', 'kasir']}>
            <Order />
          </ProtectedRoute>
        }
      />
      <Route
        path="/order/:id"
        element={
          <ProtectedRoute allowedRoles={['admin', 'kasir']}>
            <OrderDetail />
          </ProtectedRoute>
        }
      />
      <Route
        path="/allorderdetails"
        element={
          <ProtectedRoute allowedRoles={['admin', 'koki']}>
            <AllOrderDetails />
          </ProtectedRoute>
        }
      />
    </>
  );

  return (
    <div className="d-flex flex-column min-vh-100">
      {/* Layout based on user type */}
      {!isAuthenticated || user?.level === 'customer' ? (
        // Customer Layout
        <>
          <CustomerNavbar />
          <div className="container-fluid flex-grow-1">
            <div className="row">
              <div className="col-12">
                <Routes>
                  {publicRoutes}
                  {customerRoutes}
                  <Route path="/" element={<Navigate to={getRedirectPage()} replace />} />
                </Routes>
              </div>
            </div>
          </div>
          <CustomerFooter />
        </>
      ) : (
        // Admin/Staff Layout
        <>
          <Navbar />
          <div className="container-fluid flex-grow-1">
            <div className="row">
              <div className="col-md-2 bg-light">
                <Sidebar />
              </div>
              <div className="col-md-10">
                <Routes>
                  {adminRoutes}
                  <Route path="/" element={<Navigate to={getRedirectPage()} replace />} />
                </Routes>
              </div>
            </div>
          </div>
          <Footer />
        </>
      )}
    </div>
  );
};

export default App;
