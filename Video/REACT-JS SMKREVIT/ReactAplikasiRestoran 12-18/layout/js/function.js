import { getPelanggan } from './get.js';
import { showPelanggan } from './show.js';
import { postPelanggan } from './post.js';
import { deletePelanggan } from './delete.js';
import { updatePelanggan } from './update.js';
import { searchById, toggleSearchForm } from './search.js';

// Fungsi untuk menampilkan form pelanggan
function showFormPelanggan() {
    document.getElementById('form-pelanggan').style.display = 'grid';
}

// Fungsi untuk menyembunyikan form pelanggan
function hideFormPelanggan() {
    document.getElementById('form-pelanggan').style.display = 'none';
}

// Fungsi untuk menangani klik tombol tambah data
function handlePostClick() {
    showFormPelanggan();
    postPelanggan();
}

// Fungsi untuk menangani klik tombol perbarui data
function handleUpdateClick() {
    showFormPelanggan();
    updatePelanggan();
}

// Event listeners
document.getElementById('btn-get').addEventListener('click', getPelanggan);
document.getElementById('btn-show').addEventListener('click', showPelanggan);
document.getElementById('btn-post').addEventListener('click', handlePostClick);
document.getElementById('btn-delete').addEventListener('click', deletePelanggan);
document.getElementById('btn-update').addEventListener('click', handleUpdateClick);
document.getElementById('btn-search').addEventListener('click', toggleSearchForm);
document.getElementById('btn-search-id').addEventListener('click', searchById);

// Sembunyikan form pencarian dan form pelanggan saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-search').style.display = 'none';
    hideFormPelanggan();
});

// Optional: Load data when page opens
// window.onload = getPelanggan;