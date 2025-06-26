<?php
    $id = $_SESSION["id"];

    // Müşteri bilgilerini al
    $musteri_bilgileri = DB->row("SELECT * FROM musteriler WHERE kullanici_id = :id", [
        "id" => $id,
    ]);

    $musteri_id = $musteri_bilgileri["id"];

     $veri["randevular"] = DB->query("
   SELECT 
    r.id AS randevu_id,
    r.sorun_tanimi,
    r.randevu_tarih,
    r.randevu_saat,
    r.durum,
    t.id AS traktor_id,
    t.marka,
    t.model,
    t.plaka,
    t.sasi_no,
    t.ithal_sasi_no
FROM randevular r
INNER JOIN traktorler t ON r.traktor_id = t.id
WHERE r.musteri_id = :musteri_id
", [
    "musteri_id" => $musteri_id
]);
?>
<script src="<?=ANASAYFA?>baslik"></script>

<div class="content-wrapper p-3">


  <section class="content">

    <div class="container-fluid">

      
      <div class="card">

        <div class="card-header bg-primary">
          <h3 class="card-title text-white">Randevu Durumu</h3>

        </div>

<?php foreach ($veri["randevular"] as $row) { ?>
        <div class="card-body">

          
          <ul class="list-group mb-4">
            
            <li class="list-group-item"><strong>Tarih:</strong> <?= $row["randevu_tarih"] ?></li>
            <li class="list-group-item"><strong>Saat:</strong> <?= $row["randevu_saat"] ?></li>
            <li class="list-group-item"><strong>Durum:</strong> <?= $row["durum"] ?></li>
            <li class="list-group-item"><strong>Marka:</strong> <?= $row["marka"] ?></li>
            <li class="list-group-item"><strong>Model:</strong> <?= $row["model"] ?></li>
            <li class="list-group-item"><strong>Şasi No:</strong> <?= $row["sasi_no"] ?></li>
            <li class="list-group-item"><strong>İthal Şasi No:</strong> <?= $row["ithal_sasi_no"] ?></li>
            <li class="list-group-item"><strong>Plaka:</strong> <?= $row["plaka"] ?></li>
            <li class="list-group-item"><strong>Sorun Tanımı:</strong> <?= $row["sorun_tanimi"] ?></li>
          </ul>
           
          <!-- Progress Bar adminLTE  -->
          <!-- Progress Bar adminLTE -->
<div class="mb-3">
  <label><strong>Randevu Süreci:</strong></label>
  <div class="progress">
    <?php
      if ($row["durum"] == "Onaylandı") {
        $barClass = "bg-success";
        $barWidth = "100%";
        $barText = "Onaylandı";
      } else {
        $barClass = "bg-warning";
        $barWidth = "60%";
        $barText = "Onay Bekliyor";
      }
    ?>
    <div class="progress-bar <?= $barClass ?> progress-bar-striped progress-bar-animated" style="width: <?= $barWidth ?>;">
      <?= $barText ?>
    </div>
  </div>
</div>



          
          <div class="d-flex gap-2"> 

            <button type="button" onclick="randevu_sil(<?= $row['randevu_id'] ?>)" class="btn btn-danger">
              <i class="bi bi-trash"></i> Sil
            </button>

          </div>
        </div>
        <?php } ?>
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


