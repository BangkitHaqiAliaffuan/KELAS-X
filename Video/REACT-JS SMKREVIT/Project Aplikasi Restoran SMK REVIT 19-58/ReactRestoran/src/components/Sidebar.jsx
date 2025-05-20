import React from "react";
import { Link, useLocation } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const Sidebar = () => {
  const location = useLocation();
  const { pathname } = location;
  const { user } = useAuth();

  const isActive = (path) => {
    return pathname === path ? "active bg-secondary text-white" : "";
  };

  // Fungsi untuk memeriksa apakah menu harus ditampilkan berdasarkan level user
  const shouldShowMenu = (allowedLevels) => {
    if (!user) return false;
    return allowedLevels.includes(user.level);
  };

  return (
    <div className="sidebar py-3">
      <h5 className="mb-3 px-3">Menu Aplikasi</h5>
      <div className="list-group list-group-flush">
        {/* Menu untuk Admin */}
        {shouldShowMenu(['admin']) && (
          <>
            <Link
              to="/kategori"
              className={`list-group-item list-group-item-action ${isActive("/kategori") || isActive("/")}`}
            >
              Kategori
            </Link>
            <Link
              to="/menu"
              className={`list-group-item list-group-item-action ${isActive("/menu")}`}
            >
              Menu
            </Link>
            <Link
              to="/pelanggan"
              className={`list-group-item list-group-item-action ${isActive("/pelanggan")}`}
            >
              Pelanggan
            </Link>
            <Link
              to="/admin"
              className={`list-group-item list-group-item-action ${isActive("/admin")}`}
            >
              User
            </Link>
          </>
        )}

        {/* Menu untuk Admin dan Kasir */}
        {shouldShowMenu(['admin', 'kasir']) && (
          <Link
            to="/order"
            className={`list-group-item list-group-item-action ${isActive("/order")}`}
          >
            Order
          </Link>
        )}

        {/* Menu untuk Admin, Kasir, dan Koki */}
        {shouldShowMenu(['admin', 'kasir', 'koki']) && (
          <Link
            to="/allorderdetails"
            className={`list-group-item list-group-item-action ${isActive("/allorderdetails")}`}
          >
            Detail Order
          </Link>
        )}
      </div>
    </div>
  );
};

export default Sidebar;
