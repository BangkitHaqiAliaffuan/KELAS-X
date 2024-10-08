let tblmenu = [

    {idmenu: 1, idkategori: 1, menu: "Nasi Goreng", gambar: "nasiGoreng.jpg", harga: 8000},
    {idmenu: 2, idkategori: 2, menu: "Mie Goreng", gambar: "mieGoreng.jpg", harga: 8000},
    {idmenu: 3, idkategori: 3, menu: "Es Teh", gambar: "esTeh.jpg", harga: 8000},
    {idmenu: 4, idkategori: 4, menu: "Es Jeruk", gambar: "esJeruk.jpg", harga: 8000},
    {idmenu: 5, idkategori: 5, menu: "Jeruk", gambar: "jeruk.jpg", harga: 8000},
    {idmenu: 6, idkategori: 6, menu: "Jeruk Chima", gambar: "jerukChina.jpg", harga: 8000},
    {idmenu: 7, idkategori: 7, menu: "Krupuk Tengiri", gambar: "krupukTengiri.jpg", harga: 8000},
    {idmenu: 8, idkategori: 8, menu: "Kue lapis", gambar: "kueLapis.jpg", harga: 8000},
    {idmenu: 9, idkategori: 9, menu: "Krupuk Udang", gambar: "krupukUdang.jpg", harga: 8000},
];

let tampil = tblmenu
    .map(function (kolom){

        return `
        
        
        <div class="product-content">
          <div class="image">
            <img src="img/${kolom.gambar}" alt="">
          </div>
          <div class="title">
            <h2>${kolom.menu}</h2>
          </div>
          <div class="harga">
            <h2>Rp.$kolom.harga</h2>
          </div>

          <div class="btn-beli">
            <button data-idmenu="${kolom.idmenu}">Beli</button>
          </div>
        </div>
        
        `;

    })
    .join("")

    let isi = document.querySelector(".product")
    isi.innerHTML = tampil;

    let btnBeli = document.querySelectorAll(".btn-beli > button");

    let cart = [];


    for (let index = 0; index < btnBeli.length; index++){
        btnbeli['index'].onclick = function () {
            // console.log(btnbeli[index].dataset["idmenu"])
            // cart.push(btnbeli[index].dataset["idmenu"])

            tblmenu.filter(function (a){
                if (a.idmenu == btnbeli[index].dataset["idmenu"]){
                    cart.push(a);
                    console.log(cart);
                }
            });
        };
    }

