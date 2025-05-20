import { getPelanggan } from './get.js';
import { showPelanggan } from './show.js';
import { postPelanggan } from './post.js';
import { deletePelanggan } from './delete.js';
import { updatePelanggan } from './update.js';

// Event listeners
document.getElementById('btn-get').addEventListener('click', getPelanggan);
document.getElementById('btn-show').addEventListener('click', showPelanggan);
document.getElementById('btn-post').addEventListener('click', postPelanggan);
document.getElementById('btn-delete').addEventListener('click', deletePelanggan);
document.getElementById('btn-update').addEventListener('click', updatePelanggan);

// Optional: Load data when page opens
// window.onload = getPelanggan;