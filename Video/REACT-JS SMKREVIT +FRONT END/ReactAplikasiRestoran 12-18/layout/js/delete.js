export function deletePelanggan() {
    return axios.delete('http://localhost:8000/api/pelanggans/26')
        .then(function (response) {
            alert('Data pelanggan berhasil dihapus');
            getPelanggan(); // Refresh tabel
        })
        .catch(function (error) {
            alert('Gagal menghapus data pelanggan');
            console.error(error);
        });
}