<script src="<?=ANASAYFA?>baslik"></script>
<div class="col-12">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="color: #332D56;">Müşteri Kaydet</h3>
                </div>

                <!-- Bu formdan gelen veriler musteriler tablosuna kaydedilecek -->
                    <div class="card-body table-responsive">
                        <div class="form-group">
                            <label>Ad</label>
                            <input type="text" name="ad" class="form-control" id="ad" required>
                        </div>

                        <div class="form-group">
                            <label>Soyad</label>
                            <input type="text" name="soyad" id="soyad" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>TC Kimlik No</label>
                            <input type="text" name="tc" class="form-control" id="tc_no" maxlength="11" pattern="[1-9][0-9]{10}" title="11 haneli geçerli bir TC Kimlik No giriniz" required>
                        </div>

                        <div class="form-group">
                            <label>E-Posta</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="ornek@gmail.com" required>
                        </div>

                        <div class="form-group">
                            <label>Telefon</label>
                                <input class="form-control" id="telefon" type="tel" name="telefonNo"  placeholder="Telefon (05xx xxx xx xx)" required maxlength="11">
                                <i class="bx bxs-phone"></i>
                            </div>

                        <div class="form-group">
                            <label>Şifre</label>
                                <input type="password" id="sifre" class="form-control" name="sifre" required>
                            </div>

                            <div class="form-group">
                                <label>Şifre Tekrar Giriniz</label>
                                <input type="password" id="sifre_tekrar" class="form-control" name="sifre_tekrar" required>
                            </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn" id="btn_kaydol" onclick="personel_musteri_kaydet(this)" style="background-color: #332D56; color: white;">Müşteri Kaydet</button>
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
