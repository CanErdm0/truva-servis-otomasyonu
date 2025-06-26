<?php
      $veri["musteriler"] = DB->query("
    SELECT k.*, m.* 
    FROM kullanicilar k
    LEFT JOIN musteriler m ON k.id = m.kullanici_id
    WHERE k.rol = 'musteri'
");
?>
<script src="<?=ANASAYFA?>baslik"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="col-12">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Yeni Randevu Oluştur</h3>
                </div>

                <!-- Bu formdan gelen veriler randevular tablosuna kaydedilecek -->
                    <div class="card-body table-responsive"> <!--  responsive hale getirildi -->

                    <div class="form-group">
                         <form method="POST">
                                    <!-- Müşteri -->
                                     <label>Müşteri Seç</label>
                                        <select name="musteri_id" id="musteri_id" class="form-control" onchange="this.form.submit()" required>
                                            <option value="" disabled selected>Seçiniz</option>
                                            <?php foreach ($veri["musteriler"] as $row): ?>
                                                <option value="<?= $row['id'] ?>" <?= isset($_POST["musteri_id"]) && $_POST["musteri_id"] == $row['id'] ? 'selected' : '' ?>>
                                                    <?= $row['ad'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        </form>
</div>

                                    <!-- Traktör -->
                                        <?php
                                         $traktorler = [];
                                            if (!empty($_POST["musteri_id"])) {
                                                $musteri_id = $_POST["musteri_id"];
                                                $traktorler = DB->query("SELECT * FROM traktorler WHERE musteri_id = '{$musteri_id}' ");
                                        }
                                    ?>
                                        <div class="form-group">
                                            <label>Traktör Seç</label>
                                    <select name="traktor_id" id="traktor_id" class="form-control" required>
                                        <?php if (empty($traktorler)): ?>
                                        <option value="">Müşteriye Kayıtlı Traktör Yok</option>
                                        <?php else: ?>
                                        <?php foreach ($traktorler as $t): ?>
                                        <option value="<?= $t['id'] ?>"><?= $t['plaka'] ?> - <?= $t['marka'] ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
</div>

                        <div class="form-group">
                            <label>Sorun Tanımı</label>
                            <textarea name="sorun" class="form-control" id="sorun_tanimi" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Randevu Tarihi</label>
                            <input type="date" name="tarih" id="randevu_tarih" class="form-control" required min="<?= date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <label>Randevu Saati</label>
                            <select name="randevu_saati" id="randevu_saat" class="form-control" required>
                                <option value="" disabled selected>Seçiniz</option>
                                <?php
                                    for ($i = 9; $i <= 16; $i++) {
                                        $saat = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                        echo "<option value=\"$saat\">$saat</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- Form gönderilince randevu verilerini kontrol edip veritabanına kaydedilmeli -->
                        <button type="button" onclick="personel_randevu_al(this)" class="btn btn-primary">Randevuyu Kaydet</button>
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
    
    <script>
$(document).ready(function () {
    $("#randevu_tarih").on("change", function () {
        const secilenTarih = new Date($(this).val());
        const bugun = new Date();
        const saatSelect = $("#randevu_saat");

        saatSelect.empty();
        saatSelect.append('<option value="" disabled selected>Seçiniz</option>');

        const secilenBugunMu = secilenTarih.toDateString() === bugun.toDateString();
        const baslangic = 9;
        const bitis = 16;

        for (let i = baslangic; i <= bitis; i++) {
            let saatStr = i.toString().padStart(2, "0") + ":00";

            if (secilenBugunMu && i <= bugun.getHours()) continue;

            saatSelect.append(`<option value="${saatStr}">${saatStr}</option>`);
        }
    });

    // Sayfa yüklenince bugünün tarihi seçiliyse filtre uygula
    if ($("#randevu_tarih").val() === "<?= date('Y-m-d') ?>") {
        $("#randevu_tarih").trigger("change");
    }
});
</script>

