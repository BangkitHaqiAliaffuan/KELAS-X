$(document).ready(function(){
    let id = "";
    let pelanggan = "";
    let alamat = "";
    let telp = "";
    $("#submit").click(function(e){
        e.preventDefault();
        id = $("#id").val();
        pelanggan = $("#pelanggan").val();
        alamat = $("#alamat").val();
        telp = $("#telp").val();

        if(id === ""){
            insertData();
        } else {
            updateData();
        }

        $("#id").val("");
        $("#pelanggan").val("");
        $("#alamat").val("");
        $("#id").val("");

    });

    $("#btn-tambah").click(function(e){
        e.preventDefault();
        $("#title").html("<p>Tambah Data</p>");
        $("#id").val("");
        $("#pelanggan").val("");
        $("#alamat").val("");
        $("#telp").val("");
    });

    $("tbody").on("click", ".btn-del", function(){
        let id = $(this).attr("data-id");   
        if(confirm("Yakin Akan Menghapus?")){
            deleteData(id);
        } 
    });


function selectUpdate(id){
    let idpelanggan = {
        idpelanggan: id,
    };
    $.ajax({
        type: "post",
        url: "php/selectupdate.php",
        cache: false,
        data: JSON.stringify(idpelanggan),
        success: function (response){
            let data = JSON.parse(respone);

            $("#id").val(data.idpelanggan);
            $("#pelanggan").val(data.pelanggan);
            $("#alamat").val(data.alamat);
            $("#telp").val(data.telp);

        },
    });
}

function selectData(){
    $.ajax({
        type: "post",
        url: "php/select.php",
        cache: false,
        dataType: "json",
        success: function (response){
            let out = "";
            let no = 1;
            $.each(response, function(key, val){
                output += `
                <tr>
                    <td>${no++}</td>
                    <td>${val.pelanggan}</td>
                    <td>${val.alamat}</td>
                    <td>${val.telp}</td>
                    <td><button class="btn btn-warning btn-del" data-id="${val.idpelanggan}">Delete</button></td>
                    <td><button class="btn btn-info" onclick="selectUpdate('${val.idpelanggan}')">Update</button></td>
                </tr>
                `;
            });
            $("#isidata").html(out);
        },
    });
}

function insertData(){
    let dataPelanggan = {
        pelanggan: pelanggan,
        alamat: alamat,
        telp: telp,
    };

    $.ajax({
        type: "post",
        url: "php/insert.php",
        cache: false,
        data: JSON.stringify(dataPelanggan),
        success: function (response){
            let out = `<p>${response}</p>`;
            $("#msg").html(out);
            selectData();
        },
    });
}

function deleteData(id){
    let idpelanggan = {
        idpelanggan: id,
    };

    $.ajax({
        type: "post",
        url: "php/delete.php",
        cache: false,
        data: JSON.stringify(idpelanggan),
        success: function (response){
            let out = `<p>${response}</p>`;
            $("#msg").html(out);
            selectData();
        },
    });
}

function updateData(){
    let dataPelanggan ={
        idpelanggan: id,
        pelanggan: pelanggan,
        alamat: alamat,
        telp: telp,
    };

    $.ajax({
        type: "post",
        url: "php/update.php",
        cache: false,
        data: JSON.stringify(dataPelanggan),
        success: function (response){
            let out = `<p>${response}</p>`;
            $("#msg").html(out);
            selectData();
        },
    });
}

selectData();
});