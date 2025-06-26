<div class="container mt-4">
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Seri No</th>
            <th>Kategori</th>
            <th>Alt Kategori</th>
            <th>Ürün Adı</th>
            <th>Marka</th>
            <th>Alış Fiyatı</th>
            <th>Satış Fiyatı</th>
            <th>Stok</th>
            <th>İşlem</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>TRV-001</td>
            <td>Motor Parçaları</td>
            <td>Filtreler</td>
            <td>Yağ Filtresi</td>
            <td>Massey Ferguson</td>
            <td>500.00 ₺</td>
            <td>750.00 ₺</td>
            <td>4</td>
            <td>
              <button class="btn btn-sm btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#stokDusModal">
                <i class="fas fa-minus-circle"></i> Stoktan Düş
              </button>
            </td>
          </tr>
          <tr>
            <td>TRV-002</td>
            <td>Fren Sistemi</td>
            <td>Debriyaj Parçaları</td>
            <td>Baskı Balata</td>
            <td>New Holland</td>
            <td>12,226.10 ₺</td>
            <td>15,000.00 ₺</td>
            <td>10</td>
            <td>
              <button class="btn btn-sm btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#stokDusModal">
                <i class="fas fa-minus-circle"></i> Stoktan Düş
              </button>
            </td>
          </tr>
          <tr>
            <td>TRV-003</td>
            <td>Elektrik Aksamı</td>
            <td>Bataryalar</td>
            <td>Akü</td>
            <td>Bosch</td>
            <td>3,000.00 ₺</td>
            <td>3,900.00 ₺</td>
            <td>6</td>
            <td>
              <button class="btn btn-sm btn-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#stokDusModal">
                <i class="fas fa-minus-circle"></i> Stoktan Düş
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>










<!--Modal -->
<div class="modal fade" id="stokDusModal" tabindex="-1" aria-labelledby="stokDusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="stokDusModalLabel">Stoktan Düş</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>
      <div class="modal-body">
        <form id="stokDusForm">

          <div class="mb-3">
            <label for="miktar" class="form-label">Düşürülecek Miktar</label>
            <input type="number" class="form-control" id="miktar" min="1" required>
          </div>

          <div class="mb-3">
            <label for="neden" class="form-label">Düşürme Nedeni</label>
            <textarea class="form-control" id="neden" rows="2" placeholder="Örnek: Hasarlı ürün, müşteri iadesi..."></textarea>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
            <button type="submit" class="btn btn-danger">Stoktan Düş</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<script>
  const stokDusModal = document.getElementById('stokDusModal');
  stokDusModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const urun = button.getAttribute('data-urun');
    const urunInput = stokDusModal.querySelector('#urunAdi');
    urunInput.value = urun;
  });

  document.getElementById('stokDusForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const urun = document.getElementById('urunAdi').value;
    const miktar = document.getElementById('miktar').value;
    const neden = document.getElementById('neden').value;

    
    console.log(`Stoktan düş: ${urun}, Miktar: ${miktar}, Neden: ${neden}`);


    
    
    const modal = bootstrap.Modal.getInstance(stokDusModal);
    modal.hide();

    
    alert(`${urun} ürünü stoktan ${miktar} adet düşüldü.`);
  });
</script>
