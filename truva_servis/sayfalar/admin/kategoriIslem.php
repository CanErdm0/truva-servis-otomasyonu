 <?php
$kategoriler_raw = DB->query("SELECT 
    k.kategoriler_adi AS kategori_ad,
    ak.alt_kategoriler_adi AS alt_kategori_ad,
    k.id AS k_id,
    ak.id AS ak_id
FROM kategoriler k
LEFT JOIN alt_kategoriler ak ON ak.kategoriler_id = k.id");

// Veriyi grupla: Kategorileri tekrar etmeden listele
$kategori_veri = [];
foreach ($kategoriler_raw as $row) {
    $k_id = $row['k_id'];
    if (!isset($kategori_veri[$k_id])) {
        $kategori_veri[$k_id] = [
            'k_id' => $row['k_id'],
            'kategori_ad' => $row['kategori_ad'],
            'alt_kategoriler' => []
        ];
    }

    if ($row['ak_id']) {
        $kategori_veri[$k_id]['alt_kategoriler'][] = [
            'ak_id' => $row['ak_id'],
            'alt_kategori_ad' => $row['alt_kategori_ad']
        ];
    }
}
?>
<script src="<?=ANASAYFA?>baslik"></script><div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
        <div class="row">

            <div class="col-lg-6 col-12"> 
            <div class="card">

                <div class="card-header text-white" style="background-color: #102E50;">
                    <h3 class="card-title">Kategori Ekle - Sil</h3>
                </div>

                <form>

                <div class="card-body">
                    <div class="form-group">
                        <label for="kategoriAdi">Kategori Adı</label>
                        <input type="text" name="kategori_adi" class="form-control" id="kategori_adi" required>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2 justify-content-center">
                    <button type="button" class="btn text-white" style="background-color: #F5C45E;" onclick="kategori_ekle_sayfası()">Ekle</button>
                    <button type="button" class="btn text-white" style="background-color: #E78B48;" data-bs-toggle="modal" data-bs-target="#kategoriSilModal">Sil</button>
                </div>
                </form>
            </div>
            </div>









            
            <div class="col-lg-6 col-12">
    <div class="card">
        <div class="card-header text-white" style="background-color: #102E50;">
            <h3 class="card-title">Yedek Parça Ekle - Sil</h3>
        </div>
        <form>
            <div class="card-body">

                <!-- Kategori Seçme Alanı -->
                <div class="form-group mb-3">
                    <label for="kategoriSec">Kategori Seç</label>
                   <select name="kategori_id" id="kategori_id" class="form-control" required>
    <option value="" disabled selected>Seçiniz</option>
    <?php foreach ($kategori_veri as $kategori): ?>
        <option value="<?= $kategori['k_id'] ?>">
            <?= $kategori['kategori_ad'] ?>
        </option>
    <?php endforeach; ?>
</select>
                </div>

                <!-- Alt Kategori Adı -->
                <div class="form-group">
                    <label for="altKategoriAdi">Alt Kategori Adı</label>
                    <input type="text" name="altKategori_adi" class="form-control" id="alt_kategori_adi" required>
                </div>
            </div>

            <div class="card-footer d-flex gap-2 justify-content-center">
                <button type="button" class="btn text-white" style="background-color: #F5C45E;"onclick="alt_kategori_ekle_sayfası()">Ekle</button>
                <button type="button" class="btn text-white" style="background-color: #E78B48;" data-bs-toggle="modal" data-bs-target="#altKategoriSilModal">Sil</button>
            </div>
        </form>
    </div>
</div>




        </div>
        </div>
    </div>
</div>





<!-- Modal Kategori -->
<div class="modal fade" id="kategoriSilModal" tabindex="-1" aria-labelledby="kategoriSilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="kategoriSilModalLabel">Kategori Sil</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="kategoriSec">Silinecek Kategoriyi Seçin</label>
                        

       <select name="kategori_id_sil" id="kategori_id_sil" class="form-select" required>
    <option value="" disabled selected>Seçiniz</option>
    <?php foreach ($kategori_veri as $kategori): ?>
        <option value="<?= $kategori['k_id'] ?>">
            <?= $kategori['kategori_ad'] ?>
        </option>
    <?php endforeach; ?>
</select>

                    </div>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" onclick="kategori_sil()">Sil</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
            </div>
        </form>
    </div>
</div>



<!--  Modal Alt Kategori -->
<div class="modal fade" id="altKategoriSilModal" tabindex="-1" aria-labelledby="altKategoriSilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="altKategoriSilModalLabel">Yedek Parça Sil</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="altKategoriSec">Silinecek Yedek Parçayı Seçin Seçin</label>
                        
                            
                        


           <select name="alt_kategori_id_sil" id="alt_kategori_id_sil" class="form-select" required>
    <option value="" disabled selected>Seçiniz</option>
    <?php foreach ($kategori_veri as $kategori): ?>
        <?php foreach ($kategori['alt_kategoriler'] as $alt_kategori): ?>
            <option value="<?= $alt_kategori['ak_id'] ?>">
                <?= $alt_kategori['alt_kategori_ad'] ?>
            </option>
        <?php endforeach; ?>
    <?php endforeach; ?>
</select>



                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"onclick="alt_kategori_sil()">Sil</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
            </div>
        </form>
    </div>
</div>








<div class="col-12 mt-4 ">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="kategoriIslem" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                
                                <th>Kategori Ad</th>
                                <th>Yedek Parça Ad</th>
                                
                                
                                
                            </tr>
                        </thead>
                       <tbody>
    <?php foreach ($kategori_veri as $kategori): ?>
        <?php if (!empty($kategori['alt_kategoriler'])): ?>
            <?php foreach ($kategori['alt_kategoriler'] as $alt_kategori): ?>
                <tr>
                    <td><?= $kategori["kategori_ad"] ?></td>
                    <td><?= $alt_kategori["alt_kategori_ad"] ?></td>
                    
                    
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td><?= $kategori["kategori_ad"] ?></td>
                <td>-</td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
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
