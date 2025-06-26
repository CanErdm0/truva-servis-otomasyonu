<?php
$randevu_onaylananlar["randevu_onaylananlar"] = DB->query("
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
    WHERE r.durum = 'Onaylandı'
    ORDER BY r.id DESC
");

$randevu_onaylanmayanlar["randevu_onaylanmayanlar"] = DB->query("
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
    WHERE r.durum IN ('Reddedildi!', 'Bekliyor')
    ORDER BY r.id DESC
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
                    <table id="gelenRandevu" class="table table-bordered table-striped display">
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
                                <th>Güncelle</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                       <?php foreach($randevu_onaylanmayanlar["randevu_onaylanmayanlar"] as $veri1) { ?>
    <tr>
                                <td><?= $veri1["id"] ?></td>
                                <td><?= $veri1["musteri_ad"] ?></td>
                                <td><?= $veri1["musteri_soyad"] ?></td>
                                <td><?= $veri1["telefon"] ?></td>
                                <td><?= $veri1["email"] ?></td>
                                <td><?= $veri1["marka"] ?></td>
                                <td><?= $veri1["model"] ?></td>
                                <td><?= $veri1["plaka"] ?></td>
                                <td><?= $veri1["sasi_no"] ?></td>
                                <td><?= $veri1["ithal_sasi_no"] ?></td>
                                <td><?= $veri1["motor_no"] ?></td>
                                <td><?= $veri1["sorun_tanimi"] ?></td>
                                <td><?= $veri1["randevu_tarih"] ?></td>
                                <td><?= $veri1["randevu_saat"] ?></td>
                                <td><?= $veri1["garanti"] ?></td>
                                <td><?= $veri1["durum"] ?></td>
                                <td>
                                    <select name="randevu_durumlari" id="randevu_durumlari_<?= $veri1['id'] ?>" class="form-control" required>
                                    <option value="" disabled selected>Seçiniz</option>
                                    <option value="Onaylandı">Onayla</option>
                                    <option value="Reddedildi!">Reddet!</option>
                                    </select>
                                </td>
                                <td><button class="btn btn-sm btn-primary" onclick="randevu_durumu_guncelle(<?= $veri1['id'] ?>)">Onayla</button></td>
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



<div class="col-12">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Onaylanan Randevular</h3>
                </div>
                <div class="card-body table-responsive"> <!--  responsive hale getirildi -->
                    <table id="gelenRandevu" class="table table-bordered table-striped display">
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
                                <th>Güncelle</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                       <?php foreach($randevu_onaylananlar["randevu_onaylananlar"] as $veri2) { ?>
    <tr>
                                <td><?= $veri2["id"] ?></td>
                                <td><?= $veri2["musteri_ad"] ?></td>
                                <td><?= $veri2["musteri_soyad"] ?></td>
                                <td><?= $veri2["telefon"] ?></td>
                                <td><?= $veri2["email"] ?></td>
                                <td><?= $veri2["marka"] ?></td>
                                <td><?= $veri2["model"] ?></td>
                                <td><?= $veri2["plaka"] ?></td>
                                <td><?= $veri2["sasi_no"] ?></td>
                                <td><?= $veri2["ithal_sasi_no"] ?></td>
                                <td><?= $veri2["motor_no"] ?></td>
                                <td><?= $veri2["sorun_tanimi"] ?></td>
                                <td><?= $veri2["randevu_tarih"] ?></td>
                                <td><?= $veri2["randevu_saat"] ?></td>
                                <td><?= $veri2["garanti"] ?></td>
                                <td><?= $veri2["durum"] ?></td>
                                <td>
                                    <select name="randevu_durumlari" id="randevu_durumlari_<?= $veri2['id'] ?>" class="form-control" required>
                                    <option value="" disabled selected>Seçiniz</option>
                                    <option value="Reddedildi!">Reddet!</option>
                                    </select>
                                </td>
                                <td><button class="btn btn-sm btn-primary" onclick="randevu_durumu_guncelle(<?= $veri2['id'] ?>)">Onayla</button></td>
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