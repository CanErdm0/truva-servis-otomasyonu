<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Randevu Sorgula</title>
    <script src="<?=ANASAYFA?>baslik"></script>
    <link rel="stylesheet" href="<?=CSSLER?>style.css">
    <link rel="icon" type="image/png" href="<?=RESIMLER?>logo2.png">
</head>
<body>

    <header class="header">
        <div>
            <a href="<?=ANASAYFA?>" class="logo">
                <img src="<?=RESIMLER?>logo.png" alt="Truva Traktör Logo">
                <span class="logo-text">TRUVA TRAKTÖR</span>
            </a>
        </div>
    </header>

    <section class="randevu-sorgula">
        <h2 class="heading"><span>Boş Randevu</span> Saatleri</h2>

        <div class="tarih-secici">
            <label for="tarih">Tarih Seçin:</label>
            <input type="date" id="tarih">
        </div>

        <div id="saatListesi" class="saat-listesi">
            <p>Lütfen bir tarih seçin.</p>
        </div>
        
        <div class="giris-uyarisi">
        Randevu almak için <a href="<?=ANASAYFA?>giris_yap">giriş yapınız</a>
        </div>
        
    </section>

    <script>
    const saatListesi = document.getElementById('saatListesi');
    const saatler = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];

    document.getElementById('tarih').addEventListener('change', function () {
        const secilenTarih = this.value;

        fetch('post_bos_saatler', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'tarih=' + encodeURIComponent(secilenTarih)
        })
        .then(res => res.json())
        .then(doluSaatler => {
            // Saat formatlarını düzelt (örneğin '13:00:00' -> '13:00')
            doluSaatler = doluSaatler.map(s => s.substring(0, 5));

            const bosSaatler = saatler.filter(saat => !doluSaatler.includes(saat));

            if (bosSaatler.length === 0) {
                saatListesi.innerHTML = `<p><strong>${secilenTarih}</strong> tarihinde boş saat yok.</p>`;
            } else {
                saatListesi.innerHTML = `<p><strong>${secilenTarih}</strong> tarihi için boş saatler:</p>`;
                const ul = document.createElement('ul');
                bosSaatler.forEach(saat => {
                    const li = document.createElement('li');
                    li.textContent = `Boş: ${saat}`;
                    ul.appendChild(li);
                });
                saatListesi.appendChild(ul);
            }
        })
        .catch(err => {
            saatListesi.innerHTML = `<p>Sunucu hatası: ${err}</p>`;
        });
    });
</script>


</body>
</html>
