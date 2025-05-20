import React from 'react';

const ListSiswa = ({ dataSiswa }) => {
  return (
    <div className="row">
      {dataSiswa.map((siswa) => (
        <div key={siswa.id} className="col-md-6 mb-3">
          <div className="card">
            <div className="card-body">
              <h5 className="card-title">{siswa.nama}</h5>
              <p className="card-text">
                <strong>Kelas:</strong> {siswa.kelas}<br />
                <strong>Alamat:</strong> {siswa.alamat}
              </p>
            </div>
          </div>
        </div>
      ))}
    </div>
  );
};

export default ListSiswa;