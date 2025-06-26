            </div>
            <!--end::Row-->                        
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline"><?=TITLE;?></div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <span>
          Copyright &copy; 2025-<i class="nav-icon bi bi-infinity"></i>;          
        </span>
        Tüm hakkı saklıdır.
        <!--end::Copyright-->




        <!-- begin:modal mesaj-->

          <!-- Tüm Mesajlar Modal -->
          <div class="modal fade" id="tumMesajlarModal" tabindex="-1" aria-labelledby="tumMesajlarLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="tumMesajlarLabel">Müşteri Mesajları</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">

                  <!--begın:Mesajlar burada listelenecek -->
                  <!-- 
                    NOT:
                    Aşağıdaki örnek mesaj yapısı geçici olarak sabit yazıldı.
                    Bu alanı veritabanından gelen müşteri mesajları ile dinamik olarak döndürülecek.
                    Her mesajda şu bilgiler bekleniyor:
                      - Gönderen Adı
                      - Mesaj içeriği (önizleme)
                      - Gönderim zamanı
                  -->

                  <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Mustafa Koç</h6>
                        <small>4 saat önce</small>
                      </div>
                      <p class="mb-1">Randevumu teyit eder misiniz? Cuma saat 10:00 demiştik.</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Elif Demirtaş</h6>
                        <small>4 saat önce</small>
                      </div>
                      <p class="mb-1">Yağ değişimi yapılıyor mu? Fiyat bilgisi alabilir miyim?</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">Cemal Yıldız</h6>
                        <small>4 saat önce</small>
                      </div>
                      <p class="mb-1">Geçen hafta bıraktığım traktör hazır mı acaba?</p>
                    </a>
                  </div>

                  <!-- end:Mesajlar burada listelenecek -->

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
              </div>
            </div>
          </div>



          <!--end:modal mesaj-->












      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->
    <!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <script src="<?=TEMA;?>dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)-->  
    
    
    <!--stok İşlem sayfası için-->

    <!-- Bootstrap 5.3.3 Bundle JS (Popper dahil) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE JS -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/js/adminlte.min.js"></script>
    
    <!--end::Script-->





    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  <!--Chart.js kütüphanesi-->
    <script src="<?=JSLER?>grafikler.js"></script>
    <script src="<?=JSLER?>yeniStokEkle.js"></script>
    <script src="<?=JSLER?>faturaIsEmriYazdir.js"></script>







    <!--begın : dataTables -->


    <!--begın : dataTables -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    

    <script>
      new DataTable('#musteriler', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });

      new DataTable('#servisKayitlari', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });

      new DataTable('#stokYonetimi1', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      new DataTable('#stokYonetimi2', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });

      new DataTable('#tedarikciBilgileri', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });

      new DataTable('#teknikPersoneller', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });

      new DataTable('#gelenRandevu', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      
      new DataTable('#servisteKullanilan', {
     language: {
       url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      
      new DataTable('#servisTurIslem', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      
      
      new DataTable('#kategoriIslem', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      
      new DataTable('#musteriTraktorEkle', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      
      new DataTable('#stok_tablo', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      
      
      
      


    </script>



<!--end : dataTables -->



<script>
  function yazdirFatura() {
    window.print();
  }
</script>

  </body>
  <!--end::Body-->
</html>