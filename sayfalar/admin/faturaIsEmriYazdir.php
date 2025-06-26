<button class="btn btn-primary no-print" onclick="yazdirFatura()">Fatura Yazdır</button>


<div id="fatura">



<div class="content">


    <div class="container my-4">

    <!-- Servis Kaşesi ve Logo -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <label class="form-label">Servis Kaşe Alanı:</label>
            <div class="border p-3" style="width: 200px; height: 100px;"></div>
        </div>




        <div class="text-end">

            <img src="<?=RESIMLER?>logo2.png" alt="Logo" style="height: 80px;">

            <div class="mt-1 fw-bold" style="font-size: 1.2rem;">
                TRUVA TRAKTÖR İŞ EMRİ FATURA
            </div>

            <div class="mt-2" style="width: 150px; margin-left: auto;">
                <label class="form-label mb-1">Fatura No:</label>
                <input type="text" name="fatura_no" class="form-control form-control-sm">
            </div>

        </div>






    </div>

    <!-- Müşteri ve Traktör Bilgileri -->
    <div class="row mb-4">
        <div class="col-md-6 border-end pe-4">
            <h6>Müşteri Bilgileri</h6>
            <input type="text" name="ad_soyad" class="form-control form-control-sm mb-2" placeholder="Ad Soyad">
            <input type="text" name="adres" class="form-control form-control-sm mb-2" placeholder="Adres">
            <input type="text" name="telefon" class="form-control form-control-sm mb-2" placeholder="Telefon">
            <label>Kabul Tarihi</label>
            <input type="datetime-local" name="kabul_tarihi" class="form-control form-control-sm mb-2" placeholder="Kabul Tarihi">
            <label>Teslim Tarihi</label>
            <input type="datetime-local" name="teslim_tarihi" class="form-control form-control-sm" placeholder="Teslim Tarihi">
        </div>
        <div class="col-md-6 ps-4">
            <h6>Traktör Bilgileri</h6>
            <input type="text" name="marka" class="form-control form-control-sm mb-2" placeholder="Marka">
            <input type="text" name="model_tipi" class="form-control form-control-sm mb-2" placeholder="Model Tipi">
            <input type="text" name="sasi_no" class="form-control form-control-sm mb-2" placeholder="Şasi No">
            <input type="text" name="motor_no" class="form-control form-control-sm mb-2" placeholder="Motor No">
            <input type="text" name="plaka_no" class="form-control form-control-sm" placeholder="Plaka No">
            <label>Çalışma Saati</label>
            <input type="number" name="calismaSaati" class="form-control form-control-sm">
            <label>Satış Tarihi</label>
            <input type="datetime-local" name="satisTarihi" class="form-control form-control-sm" placeholder="Satış Tarihi">
        </div>
    </div>

    <!-- Garanti Durumu -->
    <h6>Traktör Garanti İçinde:</h6>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="garanti_durumu" value="evet" id="garantiEvet">
        <label class="form-check-label" for="garantiEvet">Evet</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="garanti_durumu" value="hayir" id="garantiHayir">
        <label class="form-check-label" for="garantiHayir">Hayır</label>
    </div>

    <!-- Müşteri Talepleri -->
    <div class="mt-3">
        <h6>Müşteri Talepleri</h6>
        <textarea name="musteri_talepleri" class="form-control" rows="2"></textarea>
    </div>

    <!-- Parça İade ve Yakıt Durumu -->
    <div class="row mt-4 mb-4">
        <div class="col-md-6 border-end pe-4">
            <h6>Parça İadesi: (Garanti Dışı)</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parca_iade" value="evet" id="iadeEvet">
                <label class="form-check-label" for="iadeEvet">Evet</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="parca_iade" value="hayir" id="iadeHayir">
                <label class="form-check-label" for="iadeHayir">Hayır</label>
            </div>
            <p class="small mt-2">Not: Değişen parçaları müşteriye teslim ediniz.</p>
        </div>
        <div class="col-md-6 ps-4">
            <div class="mb-2">
                <label class="form-label mb-1 d-block">Yakıt Durumu</label>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="yakit_durumu" id="yakit0" value="0">
                    <label class="form-check-label" for="yakit0">0</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="yakit_durumu" id="yakit1_4" value="1/4">
                    <label class="form-check-label" for="yakit1_4">1/4</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="yakit_durumu" id="yakit1_2" value="1/2">
                    <label class="form-check-label" for="yakit1_2">1/2</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="yakit_durumu" id="yakit3_4" value="3/4">
                    <label class="form-check-label" for="yakit3_4">3/4</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="yakit_durumu" id="yakit1" value="1">
                    <label class="form-check-label" for="yakit1">1</label>
                </div>
            </div>

        </div>
    </div>

    <!-- Ön Kontrol -->
    <div class="mb-3">
        <h6>Ön Kontrol</h6>
        <p class="small">Bu kontrol sadece gözle yapılan incelemeyi kapsar, garanti içermez.</p>
        <div class="row">
            <!-- Sol Kontroller -->
            <div class="col-md-6">
                <div class="row">
                    <!-- Her bir satırda 2 kolon -->


                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Kaput</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kaput" id="kaput_normal" value="Normal">
                            <label class="form-check-label" for="kaput_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kaput" id="kaput_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="kaput_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>


                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Yan Paneller</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="yan_paneller" id="yan_paneller_normal" value="Normal">
                            <label class="form-check-label" for="yan_paneller_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="yan_paneller" id="yan_paneller_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="yan_paneller_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>


                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Sağ-Sol Çamurluk</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="camurluk" id="camurluk_normal" value="Normal">
                            <label class="form-check-label" for="camurluk_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="camurluk" id="camurluk_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="camurluk_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>



                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Kabin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kabin" id="kabin_normal" value="Normal">
                            <label class="form-check-label" for="kabin_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kabin" id="kabin_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="kabin_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>



                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Lastikler</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lastikler" id="lastikler_normal" value="Normal">
                            <label class="form-check-label" for="lastikler_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="lastikler" id="lastikler_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="lastikler_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>



                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Gösterge ve İkaz</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gosterge" id="gosterge_normal" value="Normal">
                            <label class="form-check-label" for="gosterge_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gosterge" id="gosterge_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="gosterge_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Sağ Kontroller -->
            <div class="col-md-6">
                <div class="row">



                <div class="col-12 mb-2">
                        <label class="d-block mb-1">Motor</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="motor" id="motor_normal" value="Normal">
                            <label class="form-check-label" for="motor_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="motor" id="motor_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="motor_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>



                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Şanzuman</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sanzuman" id="sanzuman_normal" value="Normal">
                            <label class="form-check-label" for="sanzuman_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sanzuman" id="sanzuman_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="sanzuman_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>


                    


                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Diferansiyel</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="diferansiyel" id="diferansiyel_normal" value="Normal">
                            <label class="form-check-label" for="diferansiyel_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="diferansiyel" id="diferansiyel_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="diferansiyel_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>



                


                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Yakıt Sistemi</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="yakit" id="yakit_normal" value="Normal">
                            <label class="form-check-label" for="yakit_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="yakit" id="yakit_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="yakit_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>



                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Radyatör</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radyator" id="radyator_normal" value="Normal">
                            <label class="form-check-label" for="radyator_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="radyator" id="radyator_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="radyator_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>



                    <div class="col-12 mb-2">
                        <label class="d-block mb-1">Hidrolik Sistem</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hidrolik" id="hidrolik_normal" value="Normal">
                            <label class="form-check-label" for="hidrolik_normal">Normal ✅</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hidrolik" id="hidrolik_kusurlu" value="Kusurlu">
                            <label class="form-check-label" for="hidrolik_kusurlu">Kusurlu ❌</label>
                        </div>
                    </div>





                </div>
            </div>
        </div>

        <label class="form-label mt-3">Ön Kontrollerde Görülen Arızalar</label>
        <textarea name="on_kontrol_ariza" class="form-control" rows="2"></textarea>
    </div>

    <!-- Yapılan İşler -->
    <div class="mb-4">
        <h6>Yapılan İşler</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>İş Tanımı</th>
                    <th>İşçilik Süresi</th>
                    <th>İşçilik Tutarı</th>
                </tr>
            </thead>
            <tbody>




            

            </tbody>
        </table>


    <!-- Mobil Hizmet -->
        <div class="section-title">Mobil Hizmet</div>

        <div class="row">

            <div class="col">
                <label class="form-label">Çıkış KM</label>
                <input type="text" name="cikis_km" class="form-control">
            </div>

            <div class="col">
                <label class="form-label">Geliş KM</label>
                <input type="text" name="gelis_km" class="form-control">
            </div>

            <div class="col">
                <label class="form-label">Yapılan KM</label>
                <input type="text" name="yapilan_km" class="form-control">
            </div>

            <div class="col">
                <label class="form-label">Gidilen Yer</label>
                <input type="text" name="gidilen_yer" class="form-control">
            </div>

            <div class="col">
                <label class="form-label">Birim Fiyat</label>
                <input type="text" name="birim_fiyat_mobil" class="form-control">
            </div>

            <div class="col">
                <label class="form-label">Toplam</label>
                <input type="text" name="toplam_mobil" class="form-control">
            </div>
        </div>


        <!-- Yedek Parça -->
        <div class="section-title mt-4">Yedek Parça</div>
            <div class="container mt-3">
                <table class="table table-bordered" id="parcaTable">
                    <thead>
                        <tr>
                            <th>Parça No</th>
                            <th>Parça Adı</th>
                            <th>Adet</th>
                            <th>Birim Fiyat</th>
                            <th>Yedek Parça Tutarı</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>






                            <td><input type="text" name="parca_no[]" class="form-control"></td>
                            <td><input type="text" name="parca_adi[]" class="form-control"></td>
                            <td><input type="number" name="adet[]" class="form-control" min="1" value="1"></td>
                            <td><input type="text" name="birim_fiyat[]" class="form-control"></td>
                            <td><input type="text" name="tutar[]" class="form-control" readonly></td>
                            <td><button type="button" class="btn btn-success btn-sm" id="addRowBtn">+</button></td>



                            
                        </tr>
                    </tbody>
                </table>
            </div>



        <!-- Onay Metni ve Tutarlar -->
        <div class="row align-items-center mb-3">

            <div class="col-md-8">
                <p class="small mb-2">
                    Yukarıda belirtilen işlerin yapılması için servisinizi yetkili kılıyorum, 
                    bu onarım formunun 
                    <a href="<?=RESIMLER?>faturaIsEmriYazdir.pdf" target="_blank" id="sartLink">genel onarım şartlarına</a> 
                    uygun olarak yapılacaktır. Şartları okudum, kabul ediyorum.
                </p>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sartCheck">
                    <label class="form-check-label" for="sartCheck">Genel onarım şartlarını okudum ve kabul ediyorum.</label>
                </div>
            </div>




            <div class="col-md-4">
                <div class="d-flex justify-content-end gap-3">
                    <div>
                        <label class="form-label mb-1">Yedek Parça Toplam</label>
                        <input type="text" name="yedek_parca_toplam" class="form-control form-control-sm" style="width: 150px;">
                    </div>
                    <div>
                        <label class="form-label mb-1">Genel Toplam</label>
                        <input type="text" name="genel_toplam" class="form-control form-control-sm" style="width: 150px;">
                    </div>
                </div>
            </div>

        </div>

        <!-- Görüş -->
        <div class="mb-3">
            <label class="form-label">Görüş</label>
            <textarea name="gorus" class="form-control" rows="2"></textarea>
        </div>

            <!-- Teslim Bilgileri -->
            <div class="section-title">Teslim Bilgileri</div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Teslim Eden</label>
                    <input type="text" name="teslim_eden" class="form-control">
                    <label class="form-label">İmza</label>

                    <div class="border" style="height: 60px;"></div>
                </div>
                <div class="col">
                    <label class="form-label">Teslim Alan</label>
                    <input type="text" name="teslim_alan" class="form-control">
                    <label class="form-label">İmza</label>

                    <div class="border" style="height: 60px;"></div>
                </div>
            </div>

        <!-- Ödeme Şekli -->
            <div class="section-title mt-4">Ödeme Şekli</div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="odeme" id="nakit" value="Nakit">
                    <label class="form-check-label" for="nakit">Nakit</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="odeme" id="kredi" value="Kredi Kartı">
                    <label class="form-check-label" for="kredi">Kredi Kartı</label>
                </div>

        <!-- Diğer -->
            <div class="mt-3">
                <label class="form-label">Diğer</label>
                <textarea name="diger" class="form-control" rows="2"></textarea>
            </div>
    </div>



</div> <!-- content -->
</div> <!-- fatura -->










