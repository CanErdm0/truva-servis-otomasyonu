    <?php
      $veri["tedarikciler"] = DB->query("
        SELECT * FROM tedarikciler 
         ");
     $kategori_veri["kategoriler"] = DB->query("SELECT * FROM kategoriler");

// Alt kategorileri getir
$alt_kategoriler = [];
if (!empty($_POST["kategori_id"])) {
    $secili_kategori_id = $_POST["kategori_id"];
    $alt_kategoriler = DB->query("SELECT * FROM alt_kategoriler WHERE kategoriler_id = '{$secili_kategori_id}' ");
}
?>
<script src="<?=ANASAYFA?>baslik"></script>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="card-title">Yeni Stok Ekle</h4>
            </div>
            <div class="card-body table-responsive"> 
                <!--  responsive hale getirildi -->
                        <!-- Kategori seçimi -->
<form method="POST">
    <div class="form-group">
        <label>Kategori Seç</label>
        <select name="kategori_id" id="kategori_id" class="form-control" onchange="this.form.submit()" required>
            <option value="" disabled selected>Seçiniz</option>
            <?php foreach ($kategori_veri["kategoriler"] as $kategori): ?>
                <option value="<?= $kategori['id'] ?>" <?= isset($_POST["kategori_id"]) && $_POST["kategori_id"] == $kategori['id'] ? 'selected' : '' ?>>
                    <?= $kategori['kategoriler_adi'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<!-- Alt kategori sadece kategori seçildiyse gelir -->
<?php if (!empty($alt_kategoriler)): ?>
    <div class="form-group">
        <label>Alt Kategori Seç</label>
        <select name="alt_kategori_id" id="alt_kategori_id" class="form-control" required>
            <option value="" disabled selected>Seçiniz</option>
            <?php foreach ($alt_kategoriler as $alt): ?>
                <option value="<?= $alt['id'] ?>"><?= $alt['alt_kategoriler_adi'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>

                    <div class="form-group">
                        <label>Seri No</label>
                        <input type="text" name="seri_no" id="seri_no" class="form-control" autofocus required>
                    </div>

                    <div class="form-group">
                        <label>Marka</label>
                        <input type="text" name="marka" id="marka" class="form-control">
                    </div>


                    <div class="form-group">
                        <label for="tedarikci">Tedarikçi</label>
                        <select name="tedarikci_id" id="tedarikci_id" class="form-control">
                            <option value=""disabled selected>Tedarikçi Seçin</option>
                            <?php foreach ($veri["tedarikciler"] as $row): ?>
                                <option value="<?= htmlspecialchars($row['id']) ?>">
                                    <?= htmlspecialchars($row['ad']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Stok Kritik Seviye</label>
                        <input type="number" name="stokKritikSeviye" id="kritik_seviye" class="form-control" id="stokKritikSeviye" required>
                    </div>


                    <div class="form-group">
                        <label>Alış Tarihi</label>
                        <input type="date" name="alis_tarihi" id="alis_tarihi" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Garanti Süresi</label>
                        <div class="input-group">
                            <input type="number" name="garanti_suresi" id="garanti_suresi" class="form-control" min="1" placeholder="Süreyi girin">
                            <div class="input-group-append">
                                <span class="input-group-text">Ay</span>
                            </div>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <label>Adet</label>
                        <input type="number" name="adet" class="form-control" id="adet" min="1" value="1" required oninput="hesaplaToplam()">
                    </div>

                    <div class="form-group">
                        <label>Birim Fiyat (₺)</label>
                        <input type="number" step="0.01" name="birim_fiyat" class="form-control" id="birim_fiyat" required oninput="hesaplaToplam()">
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="kdv_durumu" id="kdv_haric" value="haric" onchange="hesaplaToplam()">
                        <label class="form-check-label" for="kdv_haric">KDV Hariç</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="kdv_durumu" id="kdv_dahil" value="dahil" onchange="hesaplaToplam()">
                        <label class="form-check-label" for="kdv_dahil">KDV Dahil</label>
                    </div>

                    <div class="form-group">
                        <label>KDV Oranı (%)</label>
                        <input type="number" name="kdv_orani" class="form-control" id="kdv_orani" step="0.01" min="0" max="100" value="20" oninput="hesaplaToplam()">
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Ara Toplam (₺)</label>
                        <input type="text" class="form-control" id="ara_toplam" readonly>
                    </div>

                    <div class="form-group">
                        <label>KDV Tutarı (₺)</label>
                        <input type="text" class="form-control" id="kdv_tutari" readonly>
                    </div>

                    <div class="form-group">
                        <label>Genel Toplam (₺)</label>
                        <input type="text" class="form-control" id="genel_toplam" readonly>
                    </div>

                    <div class="text-right mt-3">
                        <button type="button" onclick="personel_stok_ekle(this)" class="btn btn-success">
                            <i class="fas fa-save"></i> Stok Ekle
                        </button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>
    <script src="<?=JSLER?>fonksiyonlar.js"></script>
<script>
function hesaplaToplam() {
    const adet = parseFloat(document.getElementById("adet").value) || 0;
    const birimFiyat = parseFloat(document.getElementById("birim_fiyat").value) || 0;
    const kdvOrani = parseFloat(document.getElementById("kdv_orani").value) || 0;
    const kdvDurumu = document.querySelector('input[name="kdv_durumu"]:checked')?.value;

    const araToplamBrut = adet * birimFiyat;

    if (!kdvDurumu) {
        document.getElementById("ara_toplam").value = "";
        document.getElementById("kdv_tutari").value = "";
        document.getElementById("genel_toplam").value = "";
        return;
    }

    let kdvTutarı = 0, araToplam = 0, genelToplam = 0;

    if (kdvDurumu === "dahil") {
        araToplam = araToplamBrut / (1 + (kdvOrani / 100));
        kdvTutarı = araToplamBrut - araToplam;
        genelToplam = araToplamBrut;
    } else {
        araToplam = araToplamBrut;
        kdvTutarı = araToplam * (kdvOrani / 100);
        genelToplam = araToplam + kdvTutarı;
    }

    document.getElementById("ara_toplam").value = araToplam.toFixed(2);
    document.getElementById("kdv_tutari").value = kdvTutarı.toFixed(2);
    document.getElementById("genel_toplam").value = genelToplam.toFixed(2);
}
</script>
