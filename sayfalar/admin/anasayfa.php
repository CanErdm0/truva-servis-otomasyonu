    <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/css/adminlte.min.css">
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    
    
    
    <!--begin::App Content-->
    <div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row g-3">
        <!--begin::Col-->





        <?php
$traktor_sayisi = DB->row("SELECT COUNT(*) as toplam FROM traktorler")["toplam"];
?>

<div class="col-lg-3 col-6">
    <div class="small-box text-light" style="background-color: #8E44AD;">
        <div class="inner">
            <h3><?=$traktor_sayisi?></h3>
            <p>Serviste Kayıtlı olan Traktör Sayısı</p>
        </div>

        <svg 
            class="small-box-icon" 
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 64 64" 
            fill="currentColor"
        >
            <circle cx="32" cy="32" r="30" stroke="currentColor" stroke-width="4" fill="none" />
            <g stroke="currentColor" stroke-width="2">
                <line x1="10" y1="10" x2="18" y2="18"/>
                <line x1="46" y1="46" x2="54" y2="54"/>
                <line x1="10" y1="54" x2="18" y2="46"/>
                <line x1="46" y1="18" x2="54" y2="10"/>
            </g>
            <circle cx="32" cy="32" r="12" fill="currentColor" />
            <circle cx="32" cy="32" r="3" fill="#ffffff" />
        </svg>

        <a href="<?=ANASAYFA?>servisKayitlari"
           class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
           Daha fazla bilgi <i class="bi bi-link-45deg"></i>
        </a>
    </div>
</div>









        <?php
$bekleyen_randevu = DB->row("SELECT COUNT(*) as toplam FROM randevular WHERE durum = 'Bekliyor'")["toplam"];
?>

<div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 1-->
    <div class="small-box text-light " style="background-color: #16A085;">
        <div class="inner">
            <h3><?=$bekleyen_randevu?></h3>
            <p>Randevu Onay Bekleyen</p>
        </div>
        <svg
            class="small-box-icon"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
        >
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/>
        </svg>
        <a
            href="<?=ANASAYFA?>gelenRandevu"
            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
        >
        Daha fazla bilgi <i class="bi bi-link-45deg"></i>
        </a>
    </div>
    <!--end::Small Box Widget 1-->
</div>









        

        <?php
$ariza_sayisi = DB->row("SELECT COUNT(*) as toplam FROM ariza_kayitlari")["toplam"];
?>

<div class="col-lg-3 col-6">
    <div class="small-box text-light" style="background-color: #BDC3C7;">
        <div class="inner">
            <h3><?=$ariza_sayisi?></h3>
            <p>Servis Kayıtları</p>
        </div>
        <svg class="small-box-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 3h10.5A1.5 1.5 0 0118.75 4.5v15A1.5 1.5 0 0117.25 21H6.75A1.5 1.5 0 015.25 19.5v-15A1.5 1.5 0 016.75 3z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 7.5h6M9 10.5h6M9 13.5h3" />
        </svg>
        <a href="<?=ANASAYFA?>servisKayitlari"
            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
            Daha fazla bilgi <i class="bi bi-link-45deg"></i>
        </a>
    </div>
</div>







        <?php
$gunluk_kazanc = DB->row("SELECT SUM(ucret) as toplam FROM ariza_kayitlari")["toplam"];
$gunluk_kazanc = number_format($gunluk_kazanc, 2, ',', '.');
?>

<div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 2-->
    <div class="small-box text-light" style="background-color: #D35400;"> 
        <div class="inner">
            <h3><?=$gunluk_kazanc?><sup class="fs-4">₺</sup></h3>
            <p>Toplam Kazanç (Gün)</p>
        </div>
        <svg
            class="small-box-icon"
            fill="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
        >
            <path
                d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"
            ></path>
        </svg>
        <a
            href="#"
            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
        >
        Daha fazla bilgi <i class="bi bi-link-45deg"></i>
        </a>
    </div>
    <!--end::Small Box Widget 2-->
</div>

</div>


        
        <!--end::Col-->
        
        <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
    </div>
    <!--end::App Content-->




<div class="container-fluid py-3">
    <div class="row">
        <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold text-dark">📬 Gelen Mesajlar</h5>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-secondary">
                    <th>Ad Soyad</th>
                    <th>Telefon</th>
                    <th>E-Posta</th>
                    <th>Mesaj</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>

                    <tr style="background-color: #FFFFFF;">
                        <td>Elif Kaya</td>
                        <td>0505 111 22 33</td>
                        <td>elif@gmail.com</td>
                        <td>Servis randevusu almak istiyorum.</td>
                        <td><span class="badge bg-warning text-dark">Okunmadı</span></td>

                        <td>
                            <button class="btn btn-sm btn-success rounded-pill" onclick="okunduIslemi(this)">
                                <i class="bi bi-check2-circle"></i> Okundu
                            </button>
                        </td>
                    </tr>


                    
                    <tr style="background-color: #F1F3F5;">
                        <td>Ahmet Demir</td>
                        <td>0533 444 55 66</td>
                        <td>ahmet@gmail.com</td>
                        <td>Bakım fiyatları hakkında bilgi alabilir miyim?</td>
                        <td><span class="badge bg-success">Okundu</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill" disabled>
                                <i class="bi bi-eye"></i> Görüldü
                            </button>
                        </td>
                    </tr>

                    <!-- PHP  -->

                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>








    
    




