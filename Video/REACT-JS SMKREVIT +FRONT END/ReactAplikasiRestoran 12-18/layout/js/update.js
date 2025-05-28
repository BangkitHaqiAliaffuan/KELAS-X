import { getPelanggan } from './get.js';

export function updatePelanggan() {
    const nama = document.getElementById('nama').value;
    const alamat = document.getElementById('alamat').value;
    const telp = document.getElementById('telp').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (!nama || !alamat || !telp || !email || !password) {
        alert('Semua field harus diisi!');
        return;
    }

    const data = {
        pelanggan: nama,
        alamat: alamat,
        telp: telp,
        email: email,
        password: password
    };

    return axios.put('http://localhost:8000/api/pelanggans/26', data)
        .then(function (response) {
            alert('Data pelanggan berhasil diperbarui');
            document.getElementById('form-pelanggan').reset();
            document.getElementById('form-pelanggan').style.display = 'none'; // Sembunyikan form setelah selesai
            getPelanggan(); // Refresh tabel
        })
        .catch(function (error) {
            alert('Gagal memperbarui data pelanggan');
            console.error(error);
        });
}