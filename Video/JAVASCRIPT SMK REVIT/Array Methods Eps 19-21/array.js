let nilai = [
    {nama: "Jumaidah", ipa: 80, matematika: 70},
    {nama: "Maki", ipa: 84, matematika: 30},
    {nama: "Rudi", ipa: 43, matematika: 50},
    {nama: "Lio", ipa: 67, matematika: 90},

];

let nama = ["Jumaidah", "Maki", "Rudi", "Lio"];

/*
nama.push("kudi", "Kiut");

console.log(nama.shift());

nama.unshift("Kudi", "Kiut");

console.log(nama.slice(0,3);

let mapel = ['ipa'. 'bahasa', 'matematika',];

console.log(nama.concat(mapel));

console.log(nama.concat(['ips', 'pkn', 'sejarah']))

console.log(nama.splice(0,3))

console.log(nama.pop());

console.log(nilai);

console.log(nama[0]);

console.log(nama);

for (let index = 0; index < nama.length; index++){
console.log(nama['index']);
}

nama.forEach(function(a){
console.log(a);
})

nilai.forEach(a => console.log(a));

nilai.filter(function (a){
    if(a.ipa > 80){
        console.log(a.nama);
    }
})

console.log(nilai);

nilai.filter((a) => 

    a.ipa > 79 && a.matematika > 60 ? console.log(a.nama) : null
    
);

let siswa = nilai.map(a => [a.nama, a.ipa, a.bahasa])

console.log(siswa);

mapel.sort();

console.log(mapel);

let hasil = nilai.reduce(function (a, b){
 return (a = a + b.ipa);
},0);

*/

let hasil = nilai.reduce((a, b) => (a = a + b.ipa), 0);

console.log(hasil);

