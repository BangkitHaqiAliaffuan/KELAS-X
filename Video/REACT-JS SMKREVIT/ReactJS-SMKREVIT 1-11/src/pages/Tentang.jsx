import React, { useState } from 'react'

const Tentang = () => {
  const [counter, setCounter] = useState(0);

  const tambahNilai = () => {
    setCounter(counter + 1);
  };

  const kurangNilai = () => {
    setCounter(counter - 1);
  };
  return (
    <div className="container py-5">
      <h1 className="text-center mb-4">Tentang Kami</h1>
      <div className="card shadow-lg">
        <div className="card-body text-center">
          <img 
            src="/images/school.svg" 
            alt="Gambar Sekolah" 
            className="img-fluid rounded mb-4" 
            style={{ maxWidth: '600px' }}
          />
          <p className="lead mb-4">Kami adalah institusi pendidikan yang berkomitmen untuk memberikan pendidikan berkualitas tinggi kepada siswa-siswi kami.</p>
          
          <div className="row mt-5">
            <div className="col-md-6 mb-4">
              <div className="card h-100">
                <div className="card-body">
                  <h2 className="card-title text-primary mb-3">Visi</h2>
                  <p className="card-text">Menjadi pusat pendidikan terkemuka yang menghasilkan lulusan berkualitas dan berdaya saing global.</p>
                </div>
              </div>
            </div>
            <div className="col-md-6 mb-4">
              <div className="card h-100">
                <div className="card-body">
                  <h2 className="card-title text-primary mb-3">Misi</h2>
                  <ul className="list-group list-group-flush">
                    <li className="list-group-item">Menyelenggarakan pendidikan berkualitas</li>
                    <li className="list-group-item">Mengembangkan potensi siswa secara optimal</li>
                    <li className="list-group-item">Membangun karakter dan kepribadian yang unggul</li>
                    <li className="list-group-item">Menciptakan lingkungan belajar yang kondusif</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div className="mt-5 text-center">
            <h3 className="mb-3">Counter Demo</h3>
            <p className="h4 mb-4">Nilai Counter: {counter}</p>
            <div className="d-flex justify-content-center gap-2">
              <button onClick={tambahNilai} className="btn btn-primary">Tambah</button>
              <button onClick={kurangNilai} className="btn btn-danger">Kurang</button>
            </div>
          </div>
      </div>
    </div>
    </div>
  )
}

export default Tentang