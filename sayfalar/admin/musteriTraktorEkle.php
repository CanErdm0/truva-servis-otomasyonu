    <?php
    $veri["musteriler"] = DB->query("SELECT k.*, m.* FROM kullanicilar k LEFT JOIN musteriler m ON k.id = m.kullanici_id WHERE k.rol = 'musteri' ");
?>
<script src="<?=ANASAYFA?>baslik"></script>
    
    <div class="container-fluid">
            


        <div class="card shadow mb-4 border-0">
            <div class="card-header text-white" style="background-color:rgb(0, 0, 0);">
                <h3 class="card-title mb-0">Traktör Bilgileri</h3>
            </div>

            <div class="card-body">

                <form method="post" action="" enctype="multipart/form-data">
                    
                    

                    <div class="row">
                        
                        
                     <div class="col-md-4 mb-3">
                        <label for="musteriSec">Müşteri Seç</label>
                        <form method="POST">
                                    <!-- Müşteri -->
                                        <select name="musteri_id" id="musteri_id" class="form-control" onchange="this.form.submit()" required>
                                            <option value="" disabled selected>Seçiniz</option>
                                            <?php foreach ($veri["musteriler"] as $row): ?>
                                                <option value="<?= $row['id'] ?>" <?= isset($_POST["musteri_id"]) && $_POST["musteri_id"] == $row['id'] ? 'selected' : '' ?>>
                                                    <?= $row['ad'] . ' ' . $row['soyad'] . ' - ' . $row['tc_no'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        </form>

                                         <?php
                                        $traktorler = [];
                                            if (!empty($_POST["musteri_id"])) {
                                                $musteri_id = $_POST["musteri_id"];
                                                $traktorler = DB->query("SELECT * FROM traktorler WHERE musteri_id = '{$musteri_id}' ");
                                        }
                                    ?>
                     </div>
            

                        
                        
                        
                    <div class="col-md-4 mb-3">
                        <label style="color: #131D4F;">Marka</label>
                        <input type="text" name="marka" id="marka" class="form-control border" style="border-color: #131D4F;" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="color: #131D4F;">Model</label>
                        <input type="text" name="model" id="model" class="form-control border" style="border-color: #131D4F;" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="color: #131D4F;">Model Yılı</label>
                        <input type="text" name="model_yili" id="model_yili" class="form-control border" style="border-color: #131D4F;" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="color: #131D4F;">Plaka No</label>
                        <input type="text" name="plaka" id="plaka" class="form-control border" style="border-color: #131D4F;" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="color: #131D4F;">Şasi No</label>
                        <input type="text" name="sasi_no" id="sasi_no" class="form-control border" style="border-color: #131D4F;" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="color: #131D4F;">İthal Şasi No</label>
                        <input type="text" name="ithal_sasi_no" id="ithal_sasi_no" class="form-control border" style="border-color: #131D4F;" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label style="color: #131D4F;">Motor No</label>
                        <input type="text" name="motor_no" id="motor_no" class="form-control border" style="border-color: #131D4F;" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="garanti" style="color: #131D4F;">Garanti Durumu</label>
                        <select name="garanti" id="garanti" class="form-select border" style="border-color: #131D4F;" required>
                        <option value="" disabled selected>Seçiniz</option>
                        <option value="Garanti Kapsamında">Garanti Kapsamında</option>
                        <option value="Garanti Dışı">Garanti Dışı</option>
                        <option value="Garanti Durumu Belirsiz">Garanti Durumu Belirsiz</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label style="color: #131D4F;">Ruhsat</label>
                        <input type="file" name="foto" class="form-control border" style="border-color: #131D4F;" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    </div>

                    <div class="text-end mt-3">
                    <button type="submit" class="btn text-white" onclick="admin_musteri_traktor_ekle(this)" style="background-color: #F97A00;">
                        <i class="bi bi-plus-circle"></i> Traktör Ekle
                    </button>
                    </div>

                </form>
            </div>
        </div>





    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header" style="background-color: #131D4F; color: #fff;">
                    
                    <h3 class="card-title mb-0">Mevcut Traktörler</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="musteriTraktorEkle" class="table table-striped table-bordered">
                            <thead style="background-color: rgb(0, 0, 0); color: #fff;">
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
                                <?php if (!empty($traktorler)): ?>
                                    <?php foreach ($traktorler as $t): ?>
                                        <tr>
                                            <td><?= $t["marka"] ?></td>
                                            <td><?= $t["model"] ?></td>
                                            <td><?= $t["model_yili"] ?></td>
                                            <td><?= $t["plaka"] ?></td>
                                            <td><?= $t["sasi_no"] ?></td>
                                            <td><?= $t["ithal_sasi_no"] ?></td>
                                            <td><?= $t["motor_no"] ?></td>
                                            <td><?= $t["garanti"] ?></td>
                                            <td>
                                                    Yok
                                            </td>
                                            <td>
                                                <!-- Sil veya düzenle butonu eklenecekse buraya -->
                                                <button class="btn btn-sm btn-danger" onclick="admin_traktor_sil(<?= $t['id'] ?>)">Sil</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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



