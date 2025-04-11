const commentElements = document.querySelectorAll('.num');

// Mengisi setiap elemen dengan angka acak
commentElements.forEach(element => {
    let randomNum = Math.floor(Math.random() * 300); // Ganti 300 dengan rentang yang diinginkan
    element.textContent = randomNum; // Set angka acak ke elemen
    })