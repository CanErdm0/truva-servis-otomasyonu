<?php
    $veri["musteriler"] = DB->query("
        SELECT k.*, m.* 
        FROM kullanicilar k 
        LEFT JOIN musteriler m ON k.id = m.kullanici_id 
        WHERE k.rol = 'musteri' "
    );

$servis_turu["servis_turu"] = DB->query("SELECT * FROM servis_turu ");
?>
<script src="<?=ANASAYFA?>baslik"></script>

<!DOCTYPE html>
    <html lang="tr">
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- jQuery önce yüklü olmalı -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4/5 ve AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=TEMA; ?>dist/css/adminlte.min.css"> 
    <link href="<?=TEMA; ?>plugins/select2/css/select2.min.css" rel="stylesheet" /> <!--farklı renk için select2.css dosyasını kullandım -->
    </head>

    <body class="container mt-4">
            <div class="col-12">
                <div class="container mt-4">
                    <div class="card" style="border-top: 7px solid #6f42c1;"> <!-- Mor çizgi -->
                        <div class="card-header bg-dark">
                        <h3 class="card-title text-white">Yeni Servis Kaydı Aç</h3>
                        </div>
                        <div class="card-body  bg-light">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Müşteri Seçiniz</label>
                                    <form method="POST">
                                    <!-- Müşteri -->
                                        <select name="musteri_id" id="musteri_id" class="form-control" onchange="this.form.submit()" required>
                                            <option value="" disabled selected>Seçiniz</option>
                                            <?php foreach ($veri["musteriler"] as $row): ?>
                                                <option value="<?= $row['id'] ?>" <?= isset($_POST["musteri_id"]) && $_POST["musteri_id"] == $row['id'] ? 'selected' : '' ?>>
                                                    <?= $row['ad'] . ' ' . $row['soyad'] . ' - ' . $row['tc_no'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        </form>
</div>
</div>
                                    <!-- Traktör -->
                                        <?php
                                        $traktorler = [];
                                            if (!empty($_POST["musteri_id"])) {
                                                $musteri_id = $_POST["musteri_id"];
                                                $traktorler = DB->query("SELECT * FROM traktorler WHERE musteri_id = '{$musteri_id}' ");
                                        }
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Traktör Seçiniz</label>
                                    <select name="traktor_id" id="traktor_id" class="form-control" required>
                                        <?php if (empty($traktorler)): ?>
                                        <option value="">Önce müşteri seçiniz</option>
                                        <?php else: ?>
                                        <?php foreach ($traktorler as $t): ?>
                                        <option value="<?= $t['id'] ?>"><?= $t['plaka'] ?> - <?= $t['marka'] ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                </div>
                </div>
                        
                            <!-- Servis Türü -->
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Servis Türü</label>
                               <select name="servis_turu" id="servis_turu" class="form-control"required>
                                            <option value="" disabled selected>Seçiniz</option>
                                            <?php foreach ($servis_turu["servis_turu"] as $row): ?>
                                                <option value="<?= $row['ad'] ?>">
                                                    <?= $row['ad'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                            </div>
                            <!-- Geliş Tarihi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Geliş Tarihi</label>
                                <input type="date" name="gelis_tarihi" id="gelis_tarihi" class="form-control" required>
                                </div>
                            </div>
                            
                            
                            <!-- Garanti -->
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Garanti</label>
                                    <select name="garanti" id="garanti" class="form-control select2" style="width: 100%;" required>
                                        <option value="" disabled selected>Seçiniz</option>
                                        <option value="Garanti Kapsamında">Garanti Kapsamında</option>
                                        <option value="Garanti Dışında">Garanti Dışı</option>
                                    </select>
                                </div>
                            </div>


                    
                           
                            <div class="col-md-12">
                                
                                <div class="form-group">
                                    <label>Açıklama</label>
                                    <textarea name="aciklama" rows="4" class="form-control" id="aciklama" placeholder="Servis hakkında ek bilgiler..."></textarea>
                                </div>  
                            </div>

                                
                                </div>
                            </div>
                                    
                                <div class="card-footer bg-secondary d-flex justify-content-between align-items-center">

                                    <div class="me-2">
                                        <button type="button" class="btn btn-light" onclick="personel_servis_kaydi_ekle()" >Kaydı Aç</button>
                                       <!-- <button type="button" onclick="faturaYazdir()" class="btn btn-warning">Fatura Yazdır</button>-->
                                    </div>
                                </div>



                        </div>
                    </div>
                </div>

            <!-- Select2 JavaScript dosyasını dahil ediyoruz.
                Bu kütüphane, HTML select kutularını daha şık ve kullanışlı hale getirir. -->
            <script src="<?=TEMA; ?>plugins/select2/js/select2.full.min.js"></script>

            <script>
                $(function () {
                    // Sayfa yüklendiğinde, class'ı "select2" olan tüm select kutularını Select2 ile dönüştür
                    $('.select2').select2();
                });
            </script>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>
    <script src="<?=JSLER?>fonksiyonlar.js"></script>
    <script>
    $(document).ready(function () {
        const today = new Date().toISOString().split('T')[0];
        $('#gelis_tarihi').attr('min', today);
        $('#teslim_tarihi').attr('min', today);
    });
</script>

<script>
$(document).ready(function() {
    // Ürünleri tutacağımız dizi
    var stokListesi = [];

    // Sayfa yenilendiğinde sessionStorage'dan geri yükle
    if (sessionStorage.getItem("stokListesi")) {
        stokListesi = JSON.parse(sessionStorage.getItem("stokListesi"));

        // Eski verileri tabloya geri yaz
        stokListesi.forEach(function(urun) {
            var satir = `
                <tr data-seri="${urun.seri_no}">
                    <td>${urun.seri_no}</td>
                    <td>${urun.kategori}</td>
                    <td>${urun.yedek_parca_ad}</td>
                    <td>${urun.marka}</td>
                    <td>${urun.adet}</td>
                    <td>${urun.toplam} TL</td>
                    <td><button type="button" class="btn btn-danger btn-sm sil">Sil</button></td>
                </tr>
            `;
            $("#stok_tablo tbody").append(satir);
        });

        console.log("♻️ Session'dan stok listesi yüklendi:", stokListesi);
    }

    // Ürün ekleme butonuna tıklanınca
    $(".btn-dark").click(function() {
        var seri_no_input = $("#seri_no").val().trim();
        var adet = parseInt($("#adet").val() || 0);

        // Boş veya geçersiz kontrolü
        if (seri_no_input === "" || isNaN(adet) || adet < 1) {
            alert("Lütfen geçerli bir seri numarası ve adet girin.");
            return;
        }

        // Seri numarasını normalize et (küçük harfe çevir)
        var seri_no = seri_no_input.toLowerCase();

        // Aynı seri numarası zaten listede var mı?
        var zatenVar = stokListesi.some(function(item) {
            return item.seri_no === seri_no;
        });

        if (zatenVar) {
            alert("❗ Bu ürün zaten tabloya eklenmiş.");
            return;
        }

        // Ajax ile PHP'den ürünü al
        $.ajax({
            url: "post_servis_kaydi_stok_ekle",
            type: "POST",
            dataType: "json",
            data: {
                islem: "stok_bul",
                seri_no: seri_no,
                adet: adet
            },
            success: function(urun) {
                console.log("✅ Gelen veri:", urun);

                if (urun.hata) {
                    if (urun.hata === "stok_yok") {
                        alert("🚫 Stokta bu ürün kalmamış.");
                    } else if (urun.hata === "bulunamadi") {
                        alert("❗ Bu seri numarasına ait ürün bulunamadı.");
                    } else {
                        alert("⚠️ " + urun.hata);
                    }
                    return;
                }

                if (urun && urun.id) {
                    var toplam = (urun.satis_fiyati * adet).toFixed(2);

                    // Diziye ekle (normalize edilmiş haliyle)
                    stokListesi.push({
                        seri_no: seri_no,
                        kategori: urun.kategori,
                        yedek_parca_ad: urun.yedek_parca_ad,
                        marka: urun.marka,
                        adet: adet,
                        toplam: toplam
                    });

                    // Tabloya ekle
                    var satir = `
                        <tr data-seri="${seri_no}">
                            <td>${urun.seri_no}</td>
                            <td>${urun.kategori}</td>
                            <td>${urun.yedek_parca_ad}</td>
                            <td>${urun.marka}</td>
                            <td>${adet}</td>
                            <td>${toplam} TL</td>
                            <td><button type="button" class="btn btn-danger btn-sm sil">Sil</button></td>
                        </tr>
                    `;
                    $("#stok_tablo tbody").append(satir);

                    // Temizle
                    $("#seri_no").val("").focus();
                    $("#adet").val("1");

                    // Session'a kaydet
                    stokListesiniKaydet();

                    console.log("🧾 Güncel stok listesi:", stokListesi);
                } else {
                    alert("❗ Ürün bulunamadı.");
                }
            },
            error: function(xhr, status, error) {
                console.error(" AJAX Hatası:", error);
                console.log(" XHR:", xhr);
                console.log(" Status:", status);
                alert(" Sunucu hatası oluştu. Detaylar console'da.");
            }
        });
    });

    // Silme işlemi
    $("#stok_tablo").on("click", ".sil", function() {
        var satir = $(this).closest("tr");
        var seri_no = satir.data("seri").toString().trim().toLowerCase();

        // Diziden sil
        stokListesi = stokListesi.filter(function(item) {
            return item.seri_no !== seri_no;
        });

        // Tablo satırını sil
        satir.remove();

        // Session'a kaydet
        stokListesiniKaydet();

        console.log("🧾 Güncel stok listesi (silme sonrası):", stokListesi);
    });

    // Session'a yazan fonksiyon
    function stokListesiniKaydet() {
        sessionStorage.setItem("stokListesi", JSON.stringify(stokListesi));
    }
});
</script>



