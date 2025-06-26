    <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/css/adminlte.min.css">
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    
    
    
    <!--begin::App Content-->
    <div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
        <!--begin::Col-->






        






        









        <!--end::Col-->

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











    





    
    




