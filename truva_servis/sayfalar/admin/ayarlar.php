     <?php
$kullanici_id = $_SESSION["id"];

$kullanici_bilgileri = DB->row("
    SELECT 
        k.*, 
        a.ulke, a.sehir, a.ilce, a.mahalle, a.sokak, a.cadde, a.daire
    FROM kullanicilar k
    INNER JOIN adresler a ON k.adres_id = a.id
    WHERE k.id = :id
", ["id" => $kullanici_id]);
    ?>
    <script src="<?=ANASAYFA?>baslik"></script>
    <div class="col-12">
    <section class="content">
    <div class="container-fluid">
        <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Telefon</label>
                <input type="tel" class="form-control" name="telefon" id="telefon" placeholder="<?=$kullanici_bilgileri["telefon"]?>">
            </div>

            <div class="form-group">
                <label>E-Posta</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="<?=$kullanici_bilgileri["email"]?>">
            </div>

            <div class="form-group">
    <label>Ülke</label>
    <select id="ulke" name="ulke" class="form-control">
        <option value="">Ülke seçiniz</option>
    </select>
</div>


<!-- Input alanları Turkey dışında seçilirse -->
<div class="form-group" id="sehir_input_group" style="display: none;">
    <label>Şehir</label>
    <input type="text" class="form-control" name="sehir_input" id="sehir_input" placeholder="Şehir giriniz">
</div>

<div class="form-group" id="ilce_input_group" style="display: none;">
    <label>İlçe</label>
    <input type="text" class="form-control" name="ilce_input" id="ilce_input" placeholder="İlçe giriniz">
</div>

<div class="form-group" id="mahalle_input_group" style="display: none;">
    <label>Mahalle</label>
    <input type="text" class="form-control" name="mahalle_input" id="mahalle_input" placeholder="Mahalle giriniz">
</div>









<!-- Dropdown alanları Turkey seçilirse -->

<div class="form-group">
    <label>Şehir</label>
    <select id="sehir" name="sehir" class="form-control">
        <option value="">Şehir seçiniz</option>
    </select>
</div>

<div class="form-group">
    <label>İlçe</label>
    <select id="ilce" name="ilce" class="form-control">
        <option value="">İlçe seçiniz</option>
    </select>
</div>

<div class="form-group">
    <label>Mahalle</label>
    <select id="mahalle" name="mahalle" class="form-control">
        <option value="">Mahalle seçiniz</option>
    </select>
</div>

<script>



const ulkelerURL = "https://gist.githubusercontent.com/erhan/74771d87a9707cde94b13417c1460537/raw/e48de9e790182baa85de1c3f1a4d43770a2372b9/ulke.json";

const illerURL = "https://raw.githubusercontent.com/ubeydeozdmr/turkiye-api/main/src/v1/data/provinces.min.json";
const ilcelerURL = "https://raw.githubusercontent.com/ubeydeozdmr/turkiye-api/main/src/v1/data/districts.min.json";
const mahallelerURL = "https://raw.githubusercontent.com/ubeydeozdmr/turkiye-api/main/src/v1/data/neighborhoods.min.json";

let sehirler = [];
let ilceler = [];
let mahalleler = [];

fetch(ulkelerURL)
    .then(res => res.json())
    .then(data => {
        let options = `<option value="">Ülke seçiniz</option>`;

        data.sort((a, b) => a.name.localeCompare(b.name, 'tr'));
        data.forEach(ulke => {
            options += `<option value="${ulke.name}">${ulke.name}</option>`;
        });


        document.getElementById("ulke").innerHTML = options;


    });

document.getElementById("ulke").addEventListener("change", function () {
    const secilenUlke = this.value;

    const dropdownGruplari = ["sehir", "ilce", "mahalle"];
    const inputGruplari = ["sehir_input_group", "ilce_input_group", "mahalle_input_group"];


    if (secilenUlke === "Türkiye") {
        dropdownGruplari.forEach(id => document.getElementById(id).parentElement.style.display = "block");
        inputGruplari.forEach(id => document.getElementById(id).style.display = "none");
    } else {
        dropdownGruplari.forEach(id => document.getElementById(id).parentElement.style.display = "none");
        inputGruplari.forEach(id => document.getElementById(id).style.display = "block");
    }
});

// Türkiye için şehirleri yükle
fetch(illerURL)
    .then(res => res.json())
    .then(data => {
        sehirler = data;
        const sehirSelect = document.getElementById("sehir");
        let options = `<option value="">Şehir seçiniz</option>`;
        sehirler.forEach(sehir => {
           options += `<option value="${sehir.name}" data-id="${sehir.id}">
              ${sehir.name}
            </option>`;
        });
        sehirSelect.innerHTML = options;
    });

document.getElementById("sehir").addEventListener("change", function () {
    const sehirID =  this.selectedOptions[0].dataset.id;
    document.getElementById("ilce").innerHTML = `<option value="">İlçe seçiniz</option>`;
    document.getElementById("mahalle").innerHTML = `<option value="">Mahalle seçiniz</option>`;

    if (!ilceler.length) {
        fetch(ilcelerURL)
            .then(res => res.json())
            .then(data => {
                ilceler = data;
                ilceyiYukle(sehirID);
            });
    } else {
        ilceyiYukle(sehirID);
    }
});

function ilceyiYukle(sehirID) {
    const ilceSelect = document.getElementById("ilce");
    let options = `<option value="">İlçe seçiniz</option>`;
    const ilgiliIlceler = ilceler.filter(ilce => ilce.provinceId.toString() === sehirID);

    ilgiliIlceler.forEach(ilce => {
       options += `<option value="${ilce.name}" data-id="${ilce.id}">
              ${ilce.name}
            </option>`;
    });
    ilceSelect.innerHTML = options;
}

document.getElementById("ilce").addEventListener("change", function () {
    const ilceID =  this.selectedOptions[0].dataset.id;
    document.getElementById("mahalle").innerHTML = `<option value="">Mahalle seçiniz</option>`;

    if (!mahalleler.length) {
        fetch(mahallelerURL)
            .then(res => res.json())
            .then(data => {
                mahalleler = data;
                mahalleyiYukle(ilceID);
            });
    } else {
        mahalleyiYukle(ilceID);
    }
});

function mahalleyiYukle(ilceID) {
    const mahalleSelect = document.getElementById("mahalle");
    let options = `<option value="">Mahalle seçiniz</option>`;
    const ilgiliMahalleler = mahalleler.filter(m => m.districtId.toString() === ilceID);

    ilgiliMahalleler.forEach(m => {
        options += `<option value="${m.name}">${m.name}</option>`;
    });
    mahalleSelect.innerHTML = options;
}
</script>
            
            

            <div class="form-group">
                <label>Cadde</label>
                <input type="text" name="cadde" id="cadde" class="form-control" placeholder="<?=$kullanici_bilgileri["cadde"]?>">
            </div>

            <div class="form-group">
                <label>Sokak</label>
                <input type="text" name="sokak" id="sokak" class="form-control" placeholder="<?=$kullanici_bilgileri["sokak"]?>">
            </div>

            <div class="form-group">
                <label>Daire</label>
                <input type="text" name="daire" id="daire" class="form-control" placeholder="<?=$kullanici_bilgileri["daire"]?>">
            </div>
            <hr>
            <h5>Yönetici Giriş Bilgileri</h5>
            <div class="form-group">
                <label>Ad</label>
                <input type="tel" class="form-control" name="ad" id="ad" placeholder="<?=$kullanici_bilgileri["ad"]?>">
            </div>

            <div class="form-group">
                <label>Soyad</label>
                <input type="tel" class="form-control" name="soyad" id="soyad" placeholder="<?=$kullanici_bilgileri["soyad"]?>">
            </div>

            <div class="form-group">
                <label>Yeni Şifre</label>
                <input type="password" class="form-control" name="yeni_sifre" id="sifre">
            </div>

            <div class="form-group">
                <label>Yeni Şifre (Tekrar)</label>
                <input type="password" class="form-control" name="yeni_sifre_tekrar" id="sifre_tekrar">
            </div>

            <button type="button" class="btn btn-primary mt-3" onclick="admin_ayarlar_guncelle(this)">
                <i class="fas fa-save"></i> Güncelle
            </button>
        </div>
        </div>

    </div>
    </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>
    <script src="<?=JSLER?>fonksiyonlar.js"></script>