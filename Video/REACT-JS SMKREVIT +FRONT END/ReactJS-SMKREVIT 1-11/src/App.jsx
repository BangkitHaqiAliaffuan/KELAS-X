import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import Home from './pages/Home'
import Kontak from './pages/Kontak'
import Sejarah from './pages/Sejarah'
import Tentang from './pages/Tentang'
import Siswa from './pages/Siswa'
import Navbar from './components/Navbar'
import Menu from './components/Menu'
import './styles.css'

function App() {
  return (
    <Router>
      <div className="container-fluid">
        <nav className="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
          <div className="container">
            <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span className="navbar-toggler-icon"></span>
            </button>
            <Navbar />
          </div>
        </nav>

        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/kontak" element={<Kontak />} />
          <Route path="/sejarah" element={<Sejarah />} />
          <Route path="/tentang" element={<Tentang />} />
          <Route path="/siswa" element={<Siswa />} />
          <Route path="/menu" element={<Menu />} />
        </Routes>
      </div>
    </Router>
  )
}

export default App
