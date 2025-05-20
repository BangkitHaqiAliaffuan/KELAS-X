export function showPelanggan() {
    return axios.get('http://localhost:8000/api/pelanggans/2')
        .then(function (response) {
            const pelanggan = response.data.data;
            let rows = `
                <tr>
                    <td>${pelanggan.idpelanggan}</td>
                    <td>${pelanggan.pelanggan}</td>
                    <td>${pelanggan.alamat}</td>
                    <td>${pelanggan.telp}</td>
                </tr>
            `;
            document.getElementById('tbody-pelanggan').innerHTML = rows;
        })
        .catch(function (error) {
            alert('Gagal mengambil data pelanggan');
            console.error(error);
        });
}