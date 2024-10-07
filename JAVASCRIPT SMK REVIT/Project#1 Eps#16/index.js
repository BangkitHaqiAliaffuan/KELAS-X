const incbtn = document.getElementById("incbtn");
const decbtn = document.getElementById("decbtn");
const resetbtn = document.getElementById("resetbtn");
const hasil = document.getElementById("hasil");
let count = 0;

incbtn.onclick = function(){
    count++;
    hasil.textContent = count;
}

decbtn.onclick = function(){
    count--;
    hasil.textContent = count;
}

resetbtn.onclick = function(){
    count = 0;
    hasil.textContent = count
}