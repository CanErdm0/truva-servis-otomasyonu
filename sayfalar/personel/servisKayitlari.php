    <?php
      $ariza_kayitlari["servis_kayitlari"] = DB->query("
    SELECT 
        ak.*, 
        k.ad AS musteri_ad,
        k.soyad AS musteri_soyad,
        k.telefon,
        k.email,
        t.marka,
        t.model,
        t.plaka,
        t.sasi_no,
        t.ithal_sasi_no
    FROM ariza_kayitlari ak
    INNER JOIN musteriler m ON ak.musteri_id = m.id
    INNER JOIN kullanicilar k ON m.kullanici_id = k.id
    INNER JOIN traktorler t ON ak.traktor_id = t.id
");
?>

<script src="<?=ANASAYFA?>baslik"></script>
    
    <div class="col-12">
    <section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
        <div class="col-md-6 text-right">
        <a href="yeniServiskaydiAc" class="btn" style="background-color: #6f42c1; color: white;">Yeni Servis Kaydı Aç</a>

            
            </a>
        </div>
        </div>

        <!-- Tablo Kartı -->
        <div class="card">
        <div class="card-body table-responsive"> <!--  responsive hale getirildi -->
            <!--  Veriler servis kayitlari tablosunda -->
            <table id="servisKayitlari" class="table table-bordered table-striped display ">
            <thead>
                <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Telefon</th>
                <th>E-Posta</th>
                <th>Marka</th>
                <th>Plaka</th>
                <th>Servis Türü</th>
                <th>Geliş Tarihi</th>
                <th>Teslim Tarihi</th>
                <th>Ücret</th>
                <th>Garanti</th>
                <th>Açıklama</th>
                <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
<?php foreach($ariza_kayitlari["servis_kayitlari"] as $veri) { ?>
    <tr>
        <td><?= $veri["id"] ?></td>
        <td><?= $veri["musteri_ad"] ?></td>
        <td><?= $veri["musteri_soyad"] ?></td>
        <td><?= $veri["telefon"] ?></td>
        <td><?= $veri["email"] ?></td>
        <td><?= $veri["marka"] ?></td>
        <td><?= $veri["plaka"] ?></td>
        <td><?= $veri["servis_turu"] ?></td>
        <td><?= $veri["gelis_tarihi"] ?></td>
        <td><?= $veri["teslim_tarihi"] ?></td>
        <td><?= $veri["ucret"] ?> ₺</td>
        <td><?= $veri["garanti"]?></td>
        <td><?= $veri["aciklama"] ?></td>
        <td>
            <button 
            onclick="servis_kaydi_guncelle_verileri(<?= $veri['id'] ?>)"
                type="button" 
                class="btn btn-sm btn-warning btn-guncelle"
                data-bs-toggle="modal"
                data-bs-target="#guncelleModal"
                >
                    <i class="bi bi-pencil-square"></i> Güncelle
            </button>
        </td>
    </tr>
<?php } ?>
</tbody>
            </table>
        </div>
        </div>

    </div>
    </section>

    </div>
    
    
    <!-- Modal -->
<div class="modal fade" id="guncelleModal" tabindex="-1" aria-labelledby="guncelleModalLabel" aria-hidden="true">
    
  <div class="modal-dialog modal-lg">
    <form id="guncelleForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="guncelleModalLabel">Servis Kaydı Güncelle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>
      <div class="modal-body">
          
          
          
        




        <div class="mb-3">
          <label for="teslimTarihi" class="form-label">Teslim Tarihi</label>
          <input type="date" class="form-control" id="teslim_tarihi" name="teslim_tarihi" required>
        </div>



        <div class="mb-3">
          <label for="ucret" class="form-label">İşçilik Ücreti (₺)</label>
          <input type="number" min="0" class="form-control" id="iscilik_ucreti" name="ucret" required>
        </div>
        
        

        
        <div class="mb-3">
            
          <label for="seriNo" class="form-label">Kullanılan Ürün/Yedek Parça Seri Numarasını Girin</label>
          <input type="text"  id="seri_no" class="form-control" placeholder="Seri No okutun veya yazın" autocomplete="off" autofocus />
        </div>

        <div class="mb-3">
          <label for="adet" class="form-label">Adet</label>
           <input type="number" class="form-control" id="adet" name="kullanilan_adet" min="1" value="1" required>
        </div>
        
        <div class="col-md-3">
            <div class="form-group mt-4">
                 <button type="button"  class="btn btn-dark w-100">Ekle</button>
            </div>
        </div>


        <div class="mb-4">
          <label class="form-label fw-bold">Eklenen Ürünler</label>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle text-center" id="stok_tablo">
              <thead class="table-light">
                <tr>
                  <th scope="col">Seri No</th>
                  <th scope="col">Kategori</th>
                  <th scope="col">Ürün/Yedek Parça</th>
                  <th scope="col">Marka</th>
                  <th scope="col">Adet</th>
                  <th scope="col">Toplam Fiyat</th>
                  <th scope="col">İşlem</th>
                  
                </tr>
              </thead>
              <tbody>
                <!-- Eklenen ürünler buraya gelecek -->
              </tbody>
            </table>
          </div>
        </div>

        
        
        
        

        
        <div class="mb-3">
          <label for="aciklama" class="form-label">Açıklama</label>
          <textarea class="form-control" id="aciklama" name="aciklama" rows="3" placeholder="Servis hakkında açıklama..."></textarea>
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        <button type="submit" class="btn btn-primary" onclick="personel_servis_kaydi_guncelle()">Kaydet</button>
      </div>
    </form>
  </div>
</div>

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