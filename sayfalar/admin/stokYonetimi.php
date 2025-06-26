<?php
$veri["stoklar"] = DB->query("
    SELECT 
        stoklar.seri_no,
        stoklar.kategoriler_id,
        stoklar.alt_kategoriler_id,
        stoklar.marka,
        stoklar.adet,
        stoklar.satin_alinan_adet,
        stoklar.kritik_seviye,
        stoklar.alis_tarihi,
        stoklar.garanti_suresi,
        stoklar.birim_fiyat,
        stoklar.satis_fiyati,
        stoklar.kdvDurumu,
        stoklar.kdv_orani,
        stoklar.olusturulma_tarihi,
        stoklar.guncellenme_tarihi,
        kategoriler.id AS kategori_id,
        alt_kategoriler.id AS alt_kategori_id,
        kategoriler.kategoriler_adi AS kategori_ad,
        alt_kategoriler.alt_kategoriler_adi AS alt_kategori_ad,
        tedarikciler.ad AS tedarikci_ad,
        tedarikciler.id AS tedarikci_id,

        (
            SELECT SUM(s2.adet)
            FROM stoklar s2
            WHERE 
                s2.seri_no = stoklar.seri_no AND
                s2.kategoriler_id = stoklar.kategoriler_id AND
                s2.alt_kategoriler_id = stoklar.alt_kategoriler_id AND
                s2.marka = stoklar.marka
        ) AS toplam_adet,

        (
            SELECT MAX(s3.kritik_seviye)
            FROM stoklar s3
            WHERE 
                s3.seri_no = stoklar.seri_no AND
                s3.kategoriler_id = stoklar.kategoriler_id AND
                s3.alt_kategoriler_id = stoklar.alt_kategoriler_id AND
                s3.marka = stoklar.marka
        ) AS ortak_kritik_seviye

    FROM stoklar
    INNER JOIN tedarikciler ON stoklar.tedarikci_id = tedarikciler.id
    INNER JOIN kategoriler ON stoklar.kategoriler_id = kategoriler.id
    INNER JOIN alt_kategoriler ON stoklar.alt_kategoriler_id = alt_kategoriler.id
    ORDER BY stoklar.olusturulma_tarihi DESC
");
?>
<script src="<?=ANASAYFA?>baslik"></script>

<div class="col-12">
    <section class="content">
        <div class="container-fluid">

            <div class="row mb-3">
                    <div class="col-md-6 text-right">
                        <a href="yeniStokEkle" class="btn btn-success">
                            <i class="fas fa-plus"></i> Yeni Stok Ekle
                        </a>
                    </div>
            </div>

            
            <div class="card">
                <div class="card-body table-responsive"> <!--  responsive hale getirildi -->
                    <!-- Veriler stoklar ve tedarikciler tablolarından çekilecek -->
                    <table id="stokYonetimi1" class="table table-bordered table-striped display">
                        <thead>
                            <tr>
                            <th>Seri No</th>
                            <th>Kategori</th>
                            <th>Yedek Parça Ad</th>
                            <th>Marka</th>
                            <th>Tedarikçi</th>
                            <th>Satın Alınan Adet</th>
                            <th>Toplam Mevcut Adet</th>
                            <th>Alış Tarihi</th>
                            <th>Garanti Süresi (Ay)</th>
                            <th>Birim Fiyat</th>
                            <th>KDV</th>
                            <th>KDV (%)</th>
                            <th>Stoka Ekleme Tarihi</th>
                            <th>Stok Son Güncelleme Tarihi</th>
                            <th>İşlem</th>
                            </tr>
                        </thead>



                        <tbody>
                            <?php foreach ($veri["stoklar"] as $row) { ?>
                            <!-- Veriler döngüyle basılacak -->
                            <tr>
                                <td><?= $row["seri_no"] ?></td>
                                <td><?= $row["kategori_ad"] ?></td>
                                <td><?= $row["alt_kategori_ad"] ?></td>
                                <td><?= $row["marka"] ?></td>
                                <td><?= $row["tedarikci_ad"] ?></td>
                                <td>
    <?= $row["satin_alinan_adet"] ?>
    <span class="badge rounded-pill bg-info text-dark ms-2">
        <?= $row["adet"] ?> kaldı
    </span>
</td>
                                <td>
                                    <?php
                                        $renk = "bg-success";
                                        $durum = "yeterli";
                                        if($row["toplam_adet"] <= $row["ortak_kritik_seviye"]){
                                            $renk = "bg-danger";
                                            $durum = "kritik";
                                        }
                                    ?>
                                    <span class="badge <?= $renk ?> text-white p-2">
                                        <?= ucfirst($durum) ?> (<?= $row["toplam_adet"] ?> adet) <br>
                                        <small class="text-light">Kritik seviye: <?= $row["ortak_kritik_seviye"] ?> adet belirlenmiş</small>
                                    </span>
                                </td>
                                <td><?= $row["alis_tarihi"] ?></td>
                                <td><?= $row["garanti_suresi"] ?></td>
                                <td><?= $row["birim_fiyat"] ?>₺</td>
                                <td><?= $row["kdvDurumu"] ?></td>
                                <td><?= $row["kdv_orani"] ?>%</td>
                                <td><?= $row["olusturulma_tarihi"] ?></td>
                                <td><?= $row["guncellenme_tarihi"] ?></td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-3">
                                        <button 
                                            onclick="stok_sil('<?= $row['seri_no'] ?>', '<?= $row['olusturulma_tarihi'] ?>')" 
                                            class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> Sil
                                        </button>
                                        <button
                                            onclick="var_olan_stok_ekleme_bilgileri(
                                                '<?= $row['seri_no'] ?>', 
                                                '<?= $row['kategori_id'] ?>',
                                                '<?= $row['alt_kategori_id'] ?>',
                                                '<?= $row['marka'] ?>',
                                                '<?= $row['tedarikci_id'] ?>',
                                            )"   
                                            type="button" 
                                            class="btn btn-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#stokEkleModal"
                                        >
                                            <i class="fas fa-plus-circle"></i> Stok Ekle
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            
            
            
            
            
            <div class="modal fade" id="stokEkleModal" tabindex="-1" aria-labelledby="stokEkleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="stokEkleForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stokEkleModalLabel">Yeni Stok Ekle</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="alisTarihi" class="form-label">Alış Tarihi</label>
            <input type="date" class="form-control" id="alis_tarihi" name="alis_tarihi" required>
          </div>

          <div class="mb-3">
            <label for="garantiSuresi" class="form-label">Garanti Süresi (Ay)</label>
            <input type="number" min="0" class="form-control" id="garanti_suresi" name="garanti_suresi" required>
          </div>

          <div class="mb-3">
            <label for="adet" class="form-label">Adet</label>
            <input type="number" min="1" class="form-control" id="adet" name="adet" required>
          </div>

          <div class="mb-3">
            <label>Stok Kritik Seviye</label>
            <input type="number" name="stokKritikSeviye" id="kritik_seviye" class="form-control" id="stokKritikSeviye" required>
         </div>

          <div class="mb-3">
            <label for="birimFiyat" class="form-label">Birim Fiyat (₺)</label>
            <input type="number" min="0" step="0.01" class="form-control" id="birim_fiyat" name="birim_fiyat" required>
          </div>

          <div class="mb-3">
            <label for="kdvOrani" class="form-label">KDV Oranı (%)</label>
            <input type="number" min="0" max="100" step="0.01" class="form-control" id="kdv_orani" name="kdv_orani" required>
          </div>

          <fieldset class="mb-3">
            <legend class="col-form-label pt-0">KDV Durumu</legend>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="kdv_durumu" value="dahil" required>
              <label class="form-check-label" for="kdvDahil">
                KDV Dahil
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="kdv_durumu" value="haric" required>
              <label class="form-check-label" for="kdvHaric">
                KDV Hariç
              </label>
            </div>
          </fieldset>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
          <button type="submit" onclick="var_olan_stok_ekle()" class="btn btn-primary">Stok Ekle</button>
        </div>
      </div>
    </form>
  </div>
</div>

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <div class="text-center my-4">
                <h1 class="fw-bold shadow text-black">Satış Fiyatları</h1>
            </div>
            <div class="card">
                <div class="card-body table-responsive"> <!--  responsive hale getirildi -->
                    <!-- Veriler stoklar ve tedarikciler tablolarından çekilecek -->
                    <table id="stokYonetimi2" class="table table-bordered table-striped display">
                        <thead>
                            <tr>
                            <th>Seri No</th>
                            <th>Kategori</th>
                            <th>Yedek Parça Ad</th>
                            <th>Marka</th>
                            <th>Tedarikçi</th>
                            <th>Satın Alınan Adet</th>
                            <th>Toplam Adet</th>
                            <th>Garanti Süresi (Ay)</th>
                            <th>Geliş Birim Fiyat</th>
                            <th>KDV</th>
                            <th>KDV (%)</th>
                            <th>Satış Birim Fiyat</th>
                            <th>Stoka Ekleme Tarihi</th>
                            <th>Stok Son Güncelleme Tarihi</th>
                            <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veri["stoklar"] as $row) { ?>
                            <!-- Veriler döngüyle basılacak -->
                            <tr>
                                <td><?= $row["seri_no"] ?></td>
                                <td><?= $row["kategori_ad"] ?></td>
                                <td><?= $row["alt_kategori_ad"] ?></td>
                                <td><?= $row["marka"] ?></td>
                                <td><?= $row["tedarikci_ad"] ?></td>
                                <td>
    <?= $row["satin_alinan_adet"] ?>
    <span class="badge rounded-pill bg-info text-dark ms-2">
        <?= $row["adet"] ?> kaldı
    </span>
</td>
                                <td><?= $row["toplam_adet"] ?></td>
                                <td><?= $row["garanti_suresi"] ?></td>
                                <td><?= $row["birim_fiyat"] ?>₺</td>
                                <td><?= $row["kdvDurumu"] ?></td>
                                <td><?= $row["kdv_orani"] ?>%</td>
                                <td><?= $row["satis_fiyati"] ?>₺</td>
                                <td><?= $row["olusturulma_tarihi"] ?></td>
                                <td><?= $row["guncellenme_tarihi"] ?></td>
                                <td>
                                    <button 
                                        onclick="birim_fiyat_verileri('<?= $row['seri_no'] ?>', '<?= $row['olusturulma_tarihi'] ?>')"
                                        class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#satis_fiyatlari_modal">
                                        <i class="fas fa-edit"></i> Düzenle
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>


<!-- begın: modal -->



            <div class="modal fade" id="satis_fiyatlari_modal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Stok Bilgilerini Güncelle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="modalParcaAd" class="form-label">Birim Fiyat</label>
                                    <input type="text" class="form-control" name="parcaAd" id="birim_fiyat_guncelle" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" onclick="birim_fiyat_guncelle()" class="btn btn-primary">Kaydet</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                            </div>

                        </div>
                </div>
            </div>








<script>

    function openEditModal(seriNo, parcaAd, marka) {
    document.getElementById('modalSeriNo').value = seriNo;
    document.getElementById('modalParcaAd').value = parcaAd;
    document.getElementById('modalMarka').value = marka;


    
    const myModal = new bootstrap.Modal(document.getElementById('editModal'));
    myModal.show();
    }

</script>

<!-- end: modal -->





        </div>
    </section>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="<?=JSLER?>fonksiyonlar.js"></script>