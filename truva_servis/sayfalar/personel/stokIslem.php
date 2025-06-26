    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Ürün Seri No Okut</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
        <label for="seriNoInput">Seri No</label>
        <input type="text" id="seriNoInput" class="form-control" placeholder="Seri No okutun veya yazın" autocomplete="off" autofocus />
        </div>

        <div id="urunBilgi" class="mt-4" style="display:none;">
        <h5>Ürün Bilgileri</h5>
        <table class="table table-bordered">
            <tbody>
            <tr><th>Kategori</th><td id="stokKategori"></td></tr>
            <tr><th>Ürün Adı</th><td id="urunAdi"></td></tr>
            <tr><th>Marka</th><td id="marka"></td></tr>
            <tr><th>Alış Fiyatı</th><td id="alisFiyati"></td></tr>
            <tr><th>Satış Fiyatı</th><td id="satisFiyati"></td></tr>
            <tr><th>Stok Miktarı</th><td id="stokMiktari"></td></tr>
            </tbody>
        </table>
        <button id="stokDusurBtn" class="btn btn-danger">Stoktan Düşür</button>
        </div>

        <div id="mesaj" class="mt-3"></div>
    </div>
    </div>

    <script>
const seriNoInput = document.getElementById('seriNoInput');
const urunBilgiDiv = document.getElementById('urunBilgi');
const stokKategoriTd = document.getElementById('stokKategori');
const markaTd = document.getElementById('marka');
const urunAdiTd = document.getElementById('urunAdi');
const alisFiyatiTd = document.getElementById('alisFiyati');
const satisFiyatiTd = document.getElementById('satisFiyati');
const stokMiktariTd = document.getElementById('stokMiktari');
const stokDusurBtn = document.getElementById('stokDusurBtn');
const mesajDiv = document.getElementById('mesaj');

let aktifUrun = null;

const anadizin = ""; // örnek: "/admin/"

seriNoInput.addEventListener('change', () => {
    const seriNo = seriNoInput.value.trim();
    if (!seriNo) return;

    $.post(anadizin + "post_urun_bilgisi", { seri_no: seriNo }, function(response) {
        if (response.islem === "success") {
    aktifUrun = response.veri;
    stokKategoriTd.textContent = aktifUrun.stok_kategori;
    urunAdiTd.textContent = aktifUrun.yedek_parca_ad;
    markaTd.textContent = aktifUrun.marka;
    alisFiyatiTd.textContent = parseFloat(aktifUrun.birim_fiyat).toFixed(2) + " ₺";
    satisFiyatiTd.textContent = parseFloat(aktifUrun.satis_fiyati).toFixed(2) + " ₺";
    stokMiktariTd.textContent = aktifUrun.toplam_adet;
    urunBilgiDiv.style.display = 'block';
    mesajDiv.innerHTML = "";
}
 else {
            aktifUrun = null;
            urunBilgiDiv.style.display = 'none';
            mesajDiv.innerHTML = '<div class="alert alert-danger">' + response.mesaj + '</div>';
        }
    }, "json");
});

stokDusurBtn.addEventListener('click', () => {
    if (!aktifUrun) return;

    $.post(anadizin + "post_stok_dusur", { seri_no: aktifUrun.seri_no }, function(response) {
        const tip = response.islem === "success" ? "success" :
                    response.islem === "warning" ? "warning" : "danger";
        mesajDiv.innerHTML = `<div class="alert alert-${tip}">${response.mesaj}</div>`;

        if (response.islem === "success") {
            aktifUrun.toplam_adet--;
            stokMiktariTd.textContent = aktifUrun.toplam_adet;
        }
    }, "json");
});
</script>
