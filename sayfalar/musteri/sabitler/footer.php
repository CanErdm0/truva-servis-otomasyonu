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
        T羹m hakk覺 sakl覺d覺r.
        <!--end::Copyright-->




        

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
    
    <!--begın : dataTables -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    
    <!--end::Script-->
    <script>
        new DataTable('#servisTable', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
      
      new DataTable('#traktorEkle', {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/tr.json',
        },
      });
    </script>
    
    
    
    


  </body>
  <!--end::Body-->
</html>