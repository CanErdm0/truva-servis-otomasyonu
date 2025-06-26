<?php
      $veri["musteriler"] = DB->query("
        SELECT * FROM kullanicilar 
         WHERE rol = 'musteri'
         ");
?>


<div class="col-12">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Müşteriler</h3>
                </div>
                    <div class="card-body table-responsive">  <!--  responsive hale getirildi --> 
                        <table id="musteriler" class="table table-bordered table-striped  display"> 

                            <thead>

                                <tr>
                                    <th>ID</th>
                                    <th>Ad</th>
                                    <th>Soyad</th>
                                    <th>E-posta</th>
                                    <th>Telefon</th>
                                    <th>T.C. Kimlik Numarası</th>
                                    <th>Kayıt Tarihi</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <?php foreach ($veri["musteriler"] as $row) { ?>
                                <tr>
                                    <td><?= $row["id"] ?></td>
                                    <td><?= $row["ad"] ?></td>
                                    <td><?= $row["soyad"] ?></td>
                                    <td><?= $row["email"] ?></td>
                                    <td><?= $row["telefon"] ?></td>
                                    <td><?= $row["tc_no"] ?></td>
                                    <td><?= date("d.m.Y H:i", strtotime($row["kayit_tarihi"])) ?></td>
                                </tr> 
                                    <?php } ?>
                                </tbody>

                        </table>
                    </div>
            </div>
        </div>
    </section>
</div>
