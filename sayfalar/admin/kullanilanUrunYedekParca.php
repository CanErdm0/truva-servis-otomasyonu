    <?php
$veri["stok_hareketleri"] = DB->query("
    SELECT
        k.ad,
        k.soyad,
        sh.seri_no,
        sh.miktar,
        sh.aciklama,
        sh.tarih,
        sh.kategoriler_adi,        -- isim artık burada
        sh.alt_kategoriler_adi     -- isim artık burada
    FROM stok_hareketleri sh
    LEFT JOIN musteriler  m ON sh.musteri_id  = m.id
    LEFT JOIN kullanicilar k ON m.kullanici_id = k.id
    ORDER BY sh.tarih DESC
");
?>
<script src="<?=ANASAYFA?>baslik"></script>
<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #69247C;">
                            <h3 class="card-title">Kullanılan Ürün/Yedek Parça</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="servisteKullanilan" class="table table-striped table-bordered table-hover text-nowrap w-100">
                                    <thead style="background-color: #69247C; color: white;" class="text-center">
                                        <tr>
                                        <th>Müşteri</th>
                                        <th>Seri No</th>
                                        <th>Kategori</th>
                                        <th>Ürün / Parça Adı</th>
                                        <th>Adet</th>
                                        <th>Açıklama (Neden Stoktan düştü?)</th>
                                        <th>Tarih</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="text-center">

                                    <?php foreach ($veri["stok_hareketleri"] as $row) { ?>
                <tr>
                    <td><?= $row["ad"] . ' ' . $row["soyad"] ?></td>
                    <td><?= $row["seri_no"] ?></td>
                    <td><?= $row["kategoriler_adi"] ?></td>
                    <td><?= $row["alt_kategoriler_adi"] ?></td>
                    <td><?= $row["miktar"] ?></td>
                    <td><?= $row["aciklama"] ?></td>
                    <td><?= $row["tarih"] ?></td>
                </tr> 
                <?php } ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div> 
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


