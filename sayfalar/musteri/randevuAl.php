<?php
     $id = $_SESSION["id"];

    // Müşteri bilgilerini al
    $musteri_bilgileri = DB->row("SELECT * FROM musteriler WHERE kullanici_id = :id", [
        "id" => $id,
    ]);

    $musteri_id = $musteri_bilgileri["id"];

      $veri["traktorler"] = DB->query("
        SELECT * FROM traktorler 
        WHERE musteri_id = :musteri_id", [
        "musteri_id" => $musteri_id]);
?>

<script src="<?=ANASAYFA?>baslik"></script>
<div class="col-md-8 offset-md-2">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Randevu Al</h3>
                </div>
                    <div class="card-body">
                        <!-- Kişisel Bilgiler -->

                        <!-- Traktör Bilgileri -->
                        <div class="form-group">
                            <label for="traktor">Traktörlerim</label>
                            <select name="traktor_id" id="traktor_id" class="form-control" required>
                                <option value="" disabled selected>Seçiniz</option>
                                <?php foreach ($veri["traktorler"] as $row): ?>
                                    <option value="<?= htmlspecialchars($row['id']) ?>">
                                        <?= htmlspecialchars($row['marka']) .'-'. htmlspecialchars($row['plaka']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
    

                        <div class="form-group">
                            <label>Sorun Tanımı</label>
                            <textarea name="sorun" class="form-control" id="sorun_tanimi" rows="3" placeholder="Yağ kaçağı var, motor çalışmıyor vs." required></textarea>
                        </div>

                        <!-- Randevu Bilgileri -->
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
        if ($i == 12) continue; // 12:00'i atla
        $saat = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
        echo "<option value=\"$saat\">$saat</option>";
    }
?>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="button" onclick="musteri_randevu_al(this)" class="btn btn-success btn-block">Randevuyu Al</button>
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
    $("#randevu_tarih").on("change", function() {
    let secilenTarih = $(this).val();
    let bugun = new Date().toISOString().split('T')[0];
    let secilenGun = new Date(secilenTarih).getDay(); // 0 = Pazar
    let suAnSaat = new Date().getHours();
    let saatSelect = $("#randevu_saat");

    saatSelect.html('<option value="" disabled selected>Seçiniz</option>');

    // Eğer seçilen gün Pazar ise seçim yapılmasına izin verme
    if (secilenGun === 0) {
        saatSelect.html('<option value="">Pazar günleri randevu verilemez</option>');
        return;
    }

    for (let i = 9; i <= 16; i++) {
        if (i === 12) continue; // 12:00 atlanır
        if (secilenTarih === bugun && i <= suAnSaat) continue;

        let saat = (i < 10 ? "0" : "") + i + ":00";
        saatSelect.append(`<option value="${saat}">${saat}</option>`);
    }
});

    // Sayfa yüklendiğinde bugünün tarihi seçiliyse tetiklesin
    if ($("#randevu_tarih").val() === "<?= date('Y-m-d') ?>") {
        $("#randevu_tarih").trigger("change");
    }
});
</script>
