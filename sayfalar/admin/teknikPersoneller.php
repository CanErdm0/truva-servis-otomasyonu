<?php
      $veri["personeller"] = DB->query("
    SELECT 
        k.*, 
        p.*, 
        a.sehir,
        a.ilce,
        a.mahalle,
        a.cadde,
        a.sokak,
        a.daire,
        a.ulke
    FROM kullanicilar k
    LEFT JOIN personeller p ON k.id = p.kullanici_id
    LEFT JOIN adresler a ON k.adres_id = a.id
    WHERE k.rol = 'personel'
");
?>
<script src="<?=ANASAYFA?>baslik"></script>
<div class="col-12">
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-6 text-right">
                    <a href="teknikPersonelEkle" class="btn" style="background-color: #8E1616; color: white;">
                        <i class="fas fa-plus"></i> Yeni Teknik Personel Ekle
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive"> <!-- responsive hale getirildi -->
                    <!-- Veriler teknik personeller tablosundan çekilecek -->
                    <table id="teknikPersoneller" class="table table-bordered table-striped display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Telefon</th>
                                <th>E-Posta</th>
                                <th>Ülke</th>
                <th>Adres</th>
                                <th>Görev Tanımı</th>
                                <th>Kan Grubu</th>
                                <th>İşe Başlama Tarihi</th>
                                <th>İşen Ayrılma Tarihi</th>
                                <th>Çalışma Durumu</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veri["personeller"] as $row) { ?>
                            <!-- Veriler döngüyle basılacak -->
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= $row["ad"] ?></td>
                                <td><?= $row["soyad"] ?></td>
                                <td><?= $row["telefon"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td><?= $row["ulke"] ?></td>
                    <td>
                        <?= $row['mahalle'] . ' ' . $row['cadde'] . ' ' . $row['sokak'] . ' No:' . $row['daire'] . ' ' . $row['ilce'] .'/'. $row['sehir']?>
                    </td>
                                <td><?= $row["pozisyon"] ?></td>
                                <td><?= $row["kan_grubu"] ?></td>
                                <td><?= $row["ise_baslama_tarihi"] ?></td>
                                <td><?= $row["isten_ayrilma_tarihi"] ?></td>
                                
                                
                                <td>
                             <?php
                                 $durum = $row["durum"];
                                 $renk = "bg-danger"; // Varsayılan renk

                                    switch ($durum) {
                                         case "Aktif":
                                            $renk = "bg-success";
                                         break;
                                         case "Pasif":
                                            $renk = "bg-secondary";
                                         break;
                                         case "İzinli":
                                            $renk = "bg-warning";
                                         break;
                                         case "Ayrildi":
                                            $renk = "bg-danger";
                                         break;
                                    }
                                ?>
                                        <span class="badge <?= $renk ?> text-white p-2"><?= ucfirst($durum) ?></span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#guncelleModal" onclick="personeller_guncelleme_verileri(<?= $row['id'] ?>)">
                                        <i class="fas fa-edit"></i> Güncelle
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




<!-- Modal admınlte -->
<div class="modal fade" id="guncelleModal" tabindex="-1" aria-labelledby="guncelleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border border-dark">
        <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="guncelleModalLabel">Personel Bilgilerini Güncelle</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body">
            <form id="guncelleForm">

            <div class="mb-3">
                <label for="gorevTanimi" class="form-label">Görev Tanımı</label>
                <input type="text" class="form-control" value="<?= $row['pozisyon'] ?>"id="gorevTanimi">
            </div>

            <div class="mb-3">
                <label for="calismaDurumu" class="form-label">Çalışma Durumu</label>
                <select class="form-select" id="calismaDurumu">
                <option value="Aktif">Aktif</option>
                <option value="Pasif">Pasif</option>
                <option value="İzinli">İzinli</option>
                <option value="Ayrıldı">Ayrıldı</option>
                </select>
            </div>
            </form>
        </div>
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
            <button type="button" class="btn btn-success" onclick="form_guncelle()">Kaydet</button>
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
