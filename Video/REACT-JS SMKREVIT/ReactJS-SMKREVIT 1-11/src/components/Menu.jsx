import React, { useState } from 'react';
import Tabel from './Tabel';

function Menu() {
  const [selectedCategory, setSelectedCategory] = useState('semua');
  const [menus] = useState([
    {
      idmenu: 1,
      idkategori: 1,
      menu: "Apel Manalagi",
      gambar: "apel.jpg",
      harga: 3000,
      tag: "buah"
    },
    {
      idmenu: 2,
      idkategori: 1,
      menu: "Pisang Raja",
      gambar: "pisang.jpg",
      harga: 5000,
      tag: "buah"
    },
    {
      idmenu: 3,
      idkategori: 2,
      menu: "Nasi Goreng",
      gambar: "nasigoreng.jpg",
      harga: 15000,
      tag: "makanan"
    },
    {
      idmenu: 4,
      idkategori: 2,
      menu: "Mie Goreng",
      gambar: "miegoreng.jpg",
      harga: 13000,
      tag: "makanan"
    }
  ]);

  const categories = [
    { id: 'semua', label: 'Semua' },
    { id: 'buah', label: 'Buah' },
    { id: 'makanan', label: 'Makanan' }
  ];

  const filteredMenu = selectedCategory === 'semua'
    ? menus
    : menus.filter(item => item.tag === selectedCategory);

  const headers = [
    { key: 'idmenu', label: 'ID' },
    { key: 'menu', label: 'Nama Menu' },
    { 
      key: 'harga', 
      label: 'Harga',
      format: (value) => `Rp ${value.toLocaleString()}`
    },
  ];

  const handleDetail = (item) => {
    alert(`Detail menu: ${item.menu}`);
  };

  return (
    <div className="container mt-4">
      <h2 className="mb-4">Daftar Menu</h2>
      <div className="mb-4">
        {categories.map(category => (
          <button
            key={category.id}
            className={`btn me-2 ${selectedCategory === category.id ? 'btn-primary' : 'btn-outline-primary'}`}
            onClick={() => setSelectedCategory(category.id)}
          >
            {category.label}
          </button>
        ))}
      </div>
      <Tabel 
        headers={headers}
        data={filteredMenu}
        onAction={handleDetail}
      />
    </div>
  );
}

export default Menu;