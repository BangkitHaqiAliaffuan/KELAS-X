import React, { useState } from 'react';
import ListSiswa from './ListSiswa';

const Siswa = () => {
  const [dataSiswa, setDataSiswa] = useState([
    { id: 1, nama: 'Budi Santoso', kelas: 'X RPL 1', alamat: 'Jl. Merdeka No. 123' },
    { id: 2, nama: 'Ani Wijaya', kelas: 'X RPL 1', alamat: 'Jl. Sudirman No. 456' },
    { id: 3, nama: 'Citra Dewi', kelas: 'X RPL 2', alamat: 'Jl. Gatot Subroto No. 789' },
    { id: 4, nama: 'Dedi Kurniawan', kelas: 'X RPL 2', alamat: 'Jl. Diponegoro No. 321' },
  ]);

  return (
    <div className="container mt-4">
      <h2 className="text-center mb-4">Daftar Siswa</h2>
      <ListSiswa dataSiswa={dataSiswa} />
    </div>
  );
};

export default Siswa;