export function searchById() {
    const searchType = document.getElementById('search-type').value;
    const searchId = document.getElementById('search-id').value;
    
    if (!searchId) {
        alert('Silakan masukkan ID yang ingin dicari');
        return;
    }
    
    let endpoint = '';
    
    if (searchType === 'pelanggan') {
        endpoint = `http://localhost:8000/api/pelanggans/${searchId}`;
    } else if (searchType === 'kategori') {
        endpoint = `http://localhost:8000/api/kategoris/${searchId}`;
    }
    
    return axios.get(endpoint)
        .then(function (response) {
            const data = response.data.data;
            let rows = '';
            
            if (searchType === 'pelanggan') {
                rows = `
                    <tr>
                        <td>${data.idpelanggan}</td>
                        <td>${data.pelanggan}</td>
                        <td>${data.alamat}</td>
                        <td>${data.telp}</td>
                    </tr>
                `;
            } else if (searchType === 'kategori') {
                rows = `
                    <tr>
                        <td>${data.idkategori}</td>
                        <td>${data.kategori}</td>
                        <td>${data.keterangan || '-'}</td>
                        <td>-</td>
                    </tr>
                `;
            }
            
            document.getElementById('tbody-pelanggan').innerHTML = rows;
        })
        .catch(function (error) {
            alert(`Gagal mencari data ${searchType} dengan ID ${searchId}`);
            console.error(error);
        });
}

export function toggleSearchForm() {
    const formSearch = document.getElementById('form-search');
    formSearch.style.display = formSearch.style.display === 'none' ? 'grid' : 'none';
}