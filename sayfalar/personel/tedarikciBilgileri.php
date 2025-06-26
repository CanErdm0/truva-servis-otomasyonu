    <?php
      $veri["tedarikciler"] = DB->query("
        SELECT * FROM tedarikciler 
         ");
?>
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
            <table id="tedarikciTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Telefon</th>
                <th>E-Posta</th>
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
                    <td><?= $row["tedarikci_kayit_tarihi"] ?></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-danger">Sil</a>
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