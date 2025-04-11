document.querySelector('#klik').addEventListener("click", tampil);

function tampil() {
    let url = "Javascript/27-28-json.js"
    fetch(url)
        .then(function(res){
            return res.json();
        })
        .then(function(data){
            let output = "<h1>DATA MENU</h1> <table> <th>Menu</th> <td>Harga</td> <td>Warna</td> </table>";

            data.forEach(element => {
                output += `
                <tr>
                
                <td>${element.menu}</td>
                <td>${element.harga}</td>
                <td>${element.warna[0]}</td>

                </tr>`
            });
            output += "</table>";
            document.querySelector("#isi").innerHTML = output;
        })
}

// let tblmenu = [{

//     "idmenu": 1,
//     "idkategori": 1,
//     "menu": "Mie Goreng",
//     "harga": 8000,
//     "warna": ["merah", "kuning", "hijau"],
//     "stok": false,
//     "keterangan" : null,

// },

// {
//     "idmenu": 2,
//     "idkategori": 1,
//     "menu": "Nasi Goreng",
//     "harga": 8000,
//     "warna": ["merah", "kuning", "hijau"],
//     "stok": false,
//     "keterangan" : null,

// },
// ]

// console.log(tblmenu[0].menu);