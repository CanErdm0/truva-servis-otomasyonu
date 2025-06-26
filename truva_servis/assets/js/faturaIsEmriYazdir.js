
    document.getElementById('addRowBtn').addEventListener('click', function() {
        // Tablo gövdesini al
        let tbody = document.querySelector('#parcaTable tbody');

        // Yeni satır oluştur
        let newRow = document.createElement('tr');

        // Satırın içeriği (aynısını yapıyoruz)
        newRow.innerHTML = `
            <td><input type="text" name="parca_no[]" class="form-control"></td>
            <td><input type="text" name="parca_adi[]" class="form-control"></td>
            <td><input type="number" name="adet[]" class="form-control" min="1" value="1"></td>
            <td><input type="text" name="birim_fiyat[]" class="form-control"></td>
            <td><input type="text" name="tutar[]" class="form-control" readonly></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm removeRowBtn">-</button>
            </td>
        `;

        // Yeni satırı ekle
        tbody.appendChild(newRow);
    });

    // Satır silme işlemi (delegation kullanıyoruz)
    document.querySelector('#parcaTable tbody').addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('removeRowBtn')) {
            let row = e.target.closest('tr');
            row.remove();
        }
    });
