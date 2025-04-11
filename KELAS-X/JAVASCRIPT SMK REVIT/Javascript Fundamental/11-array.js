let coba = function(){
    return "Coba Function";
};

let buah = [
    "Apel",
    "Jeruk",
    "Mangga",
    10,
    coba(),
    (tes = () => "hasil return arrow function"),
    function nama(){
        return "SMKN 2 BUDURAN";
    }
];

console.log(buah);
console.log(buah['0'])
console.log(buah['1'])

for (let i in buah){
    console.log(buah[i]);
}

console.log(buah[5]);
console.log(buah[6]);