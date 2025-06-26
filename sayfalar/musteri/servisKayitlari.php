<?php
$id = $_SESSION["id"];

// Kullanıcıya ait müşteri bilgilerini al
$musteri_bilgileri = DB->row("SELECT * FROM musteriler WHERE kullanici_id = :id", [
    "id" => $id,
]);

$musteri_id = $musteri_bilgileri["id"];

// Sadece bu müşteriye ait arıza kayıtlarını getir
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
    WHERE ak.musteri_id = :musteri_id
", [
    "musteri_id" => $musteri_id,
]);
?>
<script src="<?=ANASAYFA?>baslik"></script>
<div class="col-12">
    <section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
        <div class="col-md-6 text-right">
       

            
            </a>
        </div>
        </div>

        <!-- Tablo Kartı -->
        <div class="card">
        <div class="card-body table-responsive"> <!--  responsive hale getirildi -->
            <!--  Veriler servis kayitlari tablosunda -->
            <table id="servisTable" class="table table-bordered table-striped">
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
    </tr>
<?php } ?>
</tbody>
            </table>
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