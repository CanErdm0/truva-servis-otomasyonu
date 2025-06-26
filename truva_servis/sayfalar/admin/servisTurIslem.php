<?php
      $servis_turu["servis_turu"] = DB->query("SELECT * FROM servis_turu ");
?>
<script src="<?=ANASAYFA?>baslik"></script>
<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 mx-auto"> 
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #309898;">
                            <h3 class="card-title">Servis Türü Ekle - Sil</h3>
                        </div>

                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="servisTurAdi">Servis Türü Adı</label>
                                    <input type="text" name="servisTurAdi" class="form-control" id="servisTurAdi" required>
                                </div>
                            </div>

                            <div class="card-footer d-flex gap-2 justify-content-center">
                                <button type="submit" class="btn text-white" style="background-color: #732255;" onclick="servis_turu_kaydet()">Ekle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="col-12 mt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="servisTurIslem" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Servis Türü</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php foreach ($servis_turu["servis_turu"] as $row) { ?>
                <tr>
                    <td><?= $row["ad"] ?></td>
                    <td>
                 <button type="button" class="btn btn-outline-danger btn-sm" onclick="servis_turu_sil(<?= $row['id'] ?>)">Sil</button>
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

