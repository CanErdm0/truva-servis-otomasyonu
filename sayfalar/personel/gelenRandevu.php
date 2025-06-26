<?php
$randevu_kayitlari["randevu_kayitlari"] = DB->query("
    SELECT 
        r.*, 
        k.ad AS musteri_ad,
        k.soyad AS musteri_soyad,
        k.telefon,
        k.email,
        t.marka,
        t.model,
        t.plaka,
        t.sasi_no,
        t.ithal_sasi_no,
        t.motor_no,
        t.garanti
    FROM randevular r
    INNER JOIN musteriler m ON r.musteri_id = m.id
    INNER JOIN kullanicilar k ON m.kullanici_id = k.id
    INNER JOIN traktorler t ON r.traktor_id = t.id
");
?>
<script src="<?=ANASAYFA?>baslik"></script>
<div class="col-12">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gelen Randevu</h3>
                </div>
                <div class="card-body table-responsive"> <!--  responsive hale getirildi -->
                    <table id="gelenRandevu" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Telefon</th>
                                <th>E-Posta</th>
                                <th>Marka</th>
                                <th>Model</th>
                                <th>Plaka</th>
                                <th>Şasi No</th>
                                <th>İthal Şasi No</th>
                                <th>Motor No</th>
                                <th>Sorun Tanımı</th>
                                <th>Randevu Tarihi</th>
                                <th>Randevu Saati</th>
                                <th>Garanti Durumu</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                       <?php foreach($randevu_kayitlari["randevu_kayitlari"] as $veri) { ?>
    <tr>
                                <td><?= $veri["id"] ?></td>
                                <td><?= $veri["musteri_ad"] ?></td>
                                <td><?= $veri["musteri_soyad"] ?></td>
                                <td><?= $veri["telefon"] ?></td>
                                <td><?= $veri["email"] ?></td>
                                <td><?= $veri["marka"] ?></td>
                                <td><?= $veri["model"] ?></td>
                                <td><?= $veri["plaka"] ?></td>
                                <td><?= $veri["sasi_no"] ?></td>
                                <td><?= $veri["ithal_sasi_no"] ?></td>
                                <td><?= $veri["motor_no"] ?></td>
                                <td><?= $veri["sorun_tanimi"] ?></td>
                                <td><?= $veri["randevu_tarih"] ?></td>
                                <td><?= $veri["randevu_saat"] ?></td>
                                <td><?= $veri["garanti"] ?></td>
                                <td><?= $veri["durum"] ?></td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="<?=JSLER?>fonksiyonlar.js"></script>