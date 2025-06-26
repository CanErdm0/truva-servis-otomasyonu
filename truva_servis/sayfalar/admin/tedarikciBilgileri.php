    <?php
      $veri["tedarikciler"] = DB->query("
    SELECT 
        t.id,
        t.ad,
        t.telefon,
        t.email,
        t.web_adresi,
        t.tedarikci_kayit_tarihi,
        a.sehir,
        a.ilce,
        a.mahalle,
        a.cadde,
        a.sokak,
        a.daire,
        a.ulke
    FROM tedarikciler t
    LEFT JOIN adresler a ON t.adres_id = a.id
");
?>
<script src="<?=ANASAYFA?>baslik"></script>
    <div class="col-12">
    <section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
        <div class="col-md-6 text-right">
            <a href="yeniTedarikciEkle" class="btn btn-warning">
            <i class="fas fa-plus"></i> Yeni Tedarikçi Ekle
            </a>
        </div>
        </div>

        
        <div class="card">
        <div class="card-body table-responsive"> <!--  responsive hale getirildi -->
            <!-- Veriler tedarikciler tablosundan çekilecek -->
            <table id="tedarikciBilgileri" class="table table-bordered table-striped display">
            <thead>
                <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Telefon</th>
                <th>E-Posta</th>
                <th>Ülke</th>
                <th>Adres</th>
                <th>Web Adresi</th>
                <th>Kayıt Tarihi</th>
                <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                     <?php foreach ($veri["tedarikciler"] as $row) { ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["ad"] ?></td>
                    <td><?= $row["telefon"] ?></td>
                    <td><?= $row["email"] ?></td>
                    <td><?= $row["ulke"] ?></td>
                    <td>
                        <?= $row['mahalle'] . ' ' . $row['cadde'] . ' ' . $row['sokak'] . ' No:' . $row['daire'] . ' ' . $row['ilce'] .'/'. $row['sehir']?>
                    </td>
                    <td><?= $row['web_adresi'] ?></td>
                    <td><?= $row["tedarikci_kayit_tarihi"] ?></td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="tedarikci_sil(<?= $row['id'] ?>)">Sil</button>
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