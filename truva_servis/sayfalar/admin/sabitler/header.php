<!doctype html>
<html lang="tr">
  <!--begin::Head-->
  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="<?=RESIMLER?>logo2.png">  <!-- Favicon 10.05.2025  -->  


    <title><?= $veri["title"];?></title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="<?=TITLE;?> | TRUVA TRAKTÖR" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->    
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="<?=TEMA;?>dist/css/adminlte.css" />
    <link rel="stylesheet" href="<?=CSSLER?>faturaIsEmriYazdir.css"/>
    <!--end::Required Plugin(AdminLTE)-->
    
    


      <!--begın :  Datatables-->
      <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

  

      <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>

      <!-- end :Datatables-->
      
      
      
      
      
      


      
      
     



  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="anasayfa" class="nav-link">ANASAYFA</a></li>
          </ul>

          <!--begin::End Navbar Links-->


          <!--mesaj-->

          <ul class="navbar-nav ms-auto">
            <!--begin::Messages Dropdown Menu-->
            
          
          
          <!-- end mesaj-->

          


          <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
          
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="<?=RESIMLER;?>kullanicilarProfil/AhmetTemel.jpeg"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline"><?=isset($_SESSION["adsoyad"]) ? $_SESSION["adsoyad"] : "Misafir"; ?></span>
              </a>
              <li class="user-footer">
                  <a href="<?=ANASAYFA?>ayarlar" class="btn btn-default btn-flat">Ayarlar</a>
                  <a href="cikis_yap" class="btn btn-default btn-flat float-end">Oturumu Kapat</a>
                </li>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">                                
                <!--begin::Menu Footer-->
                
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>

          <!--end::End Navbar Links-->
        </div>

        

        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-info-subtle" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="anasayfa" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="<?=RESIMLER;?>logo2.png"
              alt="Truva Traktör Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light"><?=TITLE?></span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >                        
              <!-- Iconlar => https://icons.getbootstrap.com/ -->  



              <li class="nav-header">MENÜ</li>

              <!-- dropdonw menü -->
              <li class="nav-item menu-close">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-circle"></i>  
                  <p>
                    Müşteri
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="musteriKaydet" class="nav-link">
                    <i class="nav-icon bi bi-people"></i>
                      <p>Müşteri Kaydet</p>
                    </a>
                  </li>
                  
                  
                  
                  <li class="nav-item">
                    <a href="musteriTraktorEkle" class="nav-link">
                    <i class="nav-icon bi bi-gear-wide-connected"></i>
                      <p>Traktör Ekle</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="musteriler" class="nav-link">
                    <i class="nav-icon bi bi-people"></i>
                      <p>Müşteriler</p>
                    </a>
                  </li>
                </ul>
              </li>


            <li class="nav-item menu-close">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-circle"></i>  
                  <p>
                    Randevu
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="gelenRandevu" class="nav-link">
                      <i class="nav-icon bi bi-clock-history"></i>
                      <p>Gelen Randevu</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="yeniRandevuOlustur" class="nav-link">
                      <i class="nav-icon bi bi-calendar-plus"></i>
                      <p>Yeni Randevu Oluştur</p>
                    </a>
                  </li>


                </ul>
              </li>



              <li class="nav-item menu-close">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-circle"></i>  
                  <p>
                    Teknik Personel
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="teknikPersonelEkle" class="nav-link">
                      <i class="nav-icon bi bi-person-badge"></i>
                      <p>Teknik Personel Ekle</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="teknikPersoneller" class="nav-link">
                      <i class="nav-icon bi bi-person-gear"></i>
                      <p>Teknik Personeller</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item menu-close">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-circle"></i>  
                  <p>
                    Stok
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="yeniStokEkle" class="nav-link">
                      <i class="nav-icon bi bi-cart-plus"></i>
                      <p>Yeni Stok Ekle</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="stokYonetimi" class="nav-link">
                      <i class="nav-icon bi bi-clipboard-data"></i>
                      <p>Stok Yönetimi</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="kategoriIslem" class="nav-link">
                      <i class="nav-icon bi bi-list-ul"></i>
                      <p>Kategori işlem</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item menu-close">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-circle"></i>  
                  <p>
                    Tedarikçi
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="yeniTedarikciEkle" class="nav-link">
                      <i class="nav-icon bi bi-person-plus"></i>
                      <p>Yeni Tedarikçi Ekle</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="tedarikciBilgileri" class="nav-link">
                      <i class="nav-icon bi bi-truck"></i>
                      <p>Tedarikçi Bilgileri</p>
                    </a>
                  </li>
                </ul>
              </li>



              <li class="nav-item menu-close">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-circle"></i>  
                  <p>
                    Servis
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="yeniServisKaydiAc" class="nav-link">
                      <i class="nav-icon bi bi-plus-circle"></i>
                      <p>Yeni Servis Kaydı Aç</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="servisKayitlari" class="nav-link">
                      <i class="nav-icon bi bi-journal-text"></i>
                      <p>Servis Kayıtları</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="kullanilanUrunYedekParca" class="nav-link">
                      <i class="nav-icon bi bi-box-seam"></i>
                      <p>Kullanılan Ürün/Yedek Parça</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="servisTurIslem" class="nav-link">
                        <i class="nav-icon bi bi-tools"></i>
                        <p>Servis Tür İşlem</p>
                    </a>
                </li>
                </ul>
              </li>
              
              



              
              
              

              <li class="nav-item">
                <a href="ayarlar" class="nav-link">
                  <i class="nav-icon bi bi-gear"></i>
                  <p>Ayarlar</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="faturaIsEmriYazdir" class="nav-link">
                  <i class="nav-icon bi bi-receipt"></i>
                  <p>Fatura İş Emri Yazdır</p>
                </a>
              </li>

            
              

            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-12"><h3 class="mb-0"><?=$veri["title"];?></h3></div>              
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">