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
<div class="content-wrapper p-3">

    <section class="content">

        <div class="container-fluid">


        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title">Traktör Bilgileri</h3>
            </div>

            <div class="card-body">

            <!--    <form method="post" action=""> -->
            
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Marka</label>
                            <input type="text" name="marka"  id="marka"class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Model</label>
                            <input type="text" name="model" id="model" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Model Yılı</label>
                            <input type="text" name="model_yili" id="model_yili" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Plaka No</label>
                            <input type="text" name="plaka" id="plaka" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Şasi No</label>
                            <input type="text" name="sasi_no" id="sasi_no" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>İthal Şasi No</label>
                            <input type="text" name="ithal_sasi_no" id="ithal_sasi_no" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Motor No</label>
                            <input type="text" name="motor_no" id="motor_no" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="garanti">Garanti Durumu</label>
                            <select name="garanti" id="garanti" class="form-control" required>
                                <option value="" disabled selected>Seçiniz</option>
                                <option value="Garanti Kapsamında">Garanti Kapsamında</option>
                                <option value="Garanti Dışı">Garanti Dışı</option>
                                <option value="Garanti Durumu Belirsiz">Garanti Durumu Belirsiz</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Ruhsat</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn" onclick="musteri_traktor_ekle(this)" style="background-color: #FE7743; color: white;">
                        <i class="bi bi-plus-circle"></i> Traktör Ekle
                    </button>
                    
                </form>
            </div>
        </div>

            <div class="card">

                <div class="card-header" style="background-color: #273F4F;">
                <h3 class="card-title text-white">Kayıtlı Traktörler</h3>
                </div>
                <div class="card-body table-responsive">
                    <table id="traktorEkle" class="table table-bordered table-striped">
                        <thead style="background-color: #EFEEEA;">
                            <tr>
                                <th>Marka</th>
                                <th>Model</th>
                                <th>Model Yılı</th>
                                <th>Plaka</th>
                                <th>Şasi No</th>
                                <th>İthal Şasi No</th>
                                <th>Motor No</th>
                                <th>Garanti Durumu</th>
                                <th>Ruhsat</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veri["traktorler"] as $row) { ?>
                            <!-- Veriler döngüyle basılacak -->
                            <tr>
                                <td><?= $row["marka"] ?></td>
                                <td><?= $row["model"] ?></td>
                                <td><?= $row["model_yili"] ?></td>
                                <td><?= $row["plaka"] ?></td>
                                <td><?= $row["sasi_no"] ?></td>
                                <td><?= $row["ithal_sasi_no"] ?></td>
                                <td><?= $row["motor_no"] ?></td>
                                <td><?= $row["garanti"] ?></td>
                                
                                <td>
                                  <?php if (!empty($row["ruhsat_dosyasi"])): ?>
                        <a href="<?= RESIMLER . $row["ruhsat_dosyasi"] ?>" target="_blank" class="btn btn-sm btn-outline-info">
                            Görüntüle
                        </a>
                    <?php else: ?>
                        <span class="text-muted">Yok</span>
                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="traktor_sil(<?= $row['id'] ?>)">Sil</button>
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