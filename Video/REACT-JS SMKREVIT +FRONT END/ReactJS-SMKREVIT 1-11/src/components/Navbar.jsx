import React from 'react';
import { Link } from 'react-router-dom';

const Navbar = () => {
  const menuItems = [
    { id: 1, title: 'Home', path: '/' },
    { id: 2, title: 'Kontak', path: '/kontak' },
    { id: 3, title: 'Sejarah', path: '/sejarah' },
    { id: 4, title: 'Tentang', path: '/tentang' },
    { id: 5, title: 'Siswa', path: '/siswa' },
    { id: 6, title: 'Menu', path: '/menu' },
  ];

  return (
    <div className="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul className="navbar-nav">
        {menuItems.map((item) => (
          <li key={item.id} className="nav-item">
            <Link className="nav-link" to={item.path}>
              {item.title}
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Navbar;