<?php
// form verisi 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['mesaj'] ?? '';

    
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truva Traktör</title>
<link rel="icon" type="image/png" href="<?=RESIMLER?>logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="<?=CSSLER?>style.css">
</head>

<body>

<header class="header">
    <a href="#home" class="logo">
        <img src="<?=RESIMLER?>logo.png" alt="Truva Traktör Logo">
        <span class="logo-text">TRUVA TRAKTÖR</span>
    </a>

    <nav class="navbar">
        <a href="#home">Anasayfa</a>
        <a href="#about">Hakkımızda</a>
        <a href="#services">Hizmetler</a>
        <a href="#contact">İletişim</a>
    </nav>

    <div class="icons">
        <a href="<?=ANASAYFA?>girisTur" class="btn custom-btn">Giriş Yap</a> 
        <a href="<?=ANASAYFA?>kaydol" class="btn custom-btn">Kaydol</a>
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>
</header>

<section class="home" id="home">
    <div class="content">
        <h3>Her Parçada Güven, Her Serviste Kalite</h3>
        <p>Yılların Tecrübesiyle Hızlı, Güvenli ve Kaliteli Hizmet</p>
        <a href="<?=ANASAYFA?>randevuSorgula" class="btn">Randevu Sorgula </a>
    </div> 
</section>

<section class="about" id="about">
    <h1 class="heading"><span>Hakkımız</span>da</h1>
    <div class="row">
        <div class="image">
            <img src="<?=RESIMLER?>hakkimizda.jpg" alt="">
        </div>
        <div class="content">
            <h3>Erzincan Truva Traktör Yetkili Servis</h3>
            <p>Truva Traktör olarak, Erzincan'da traktör yedek parçaları, ekipman satışı ve teknik servis hizmetleriyle tarım 
                sektörüne destek vermekten gurur duyuyoruz. Yılların verdiği tecrübe ve güvenle, müşterilerimize kaliteli ürünler sunmakla kalmayıp,
                aynı zamanda satış sonrası destek ve bakım hizmetleriyle de yanlarında yer alıyoruz.
                Yetkili Deutz Fahr servisi olarak, traktörlerinizin bakım ve onarım süreçlerinde profesyonel çözümler sunuyor,
                arıza tespiti, parça değişimi ve periyodik bakım gibi hizmetleri en hızlı ve güvenilir şekilde sağlıyoruz.
                Müşteri memnuniyetini her zaman ön planda tutarak, dürüstlük ve kalite anlayışımızla sektörde fark yaratmayı hedefliyoruz.
                Geniş ürün yelpazemiz, deneyimli ekibimiz ve stok takip sistemimiz ile aradığınız her şeyi tek bir çatı altında bulabilirsiniz.</p>
            <p>Tarımın gücüne güç katmak için buradayız.</p>
        </div>
    </div>
</section>

<section class="services" id="services">
    <h1 class="heading">Hizmet<span>lerimiz</span></h1>
    <div class="box-container">
        <div class="box">
            <div class="image">
                <img src="<?=RESIMLER?>mobil_hizmet.jpg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">MOBİL HİZMET</a>
                <span>Erzincan / Tercan</span>
                <p>İhtiyaç durumunda ekip, bulunduğunuz konuma gelir ve yerinde servis hizmeti sunar. Zaman kaybetmeden destek alırsınız.</p>
            </div>
        </div>


        <div class="box">
            <div class="image">
                <img src="<?=RESIMLER?>periyodikBakim.jpg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">PERİYODİK BAKIM HİZMETİ</a>
                
                <p>Traktörünüzün uzun ömürlü ve sorunsuz çalışması için gereken tüm periyodik bakımları titizlikle uyguluyoruz.</p>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="<?=RESIMLER?>ariza.jpg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">ARIZA TESPİTİ</a>
                
                <p>Traktördeki mekanik ve elektriksel sorunlar dikkatlice incelenir, arızalar kısa sürede belirlenip çözüm süreci başlatılır.</p>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="<?=RESIMLER?>yedekParca.png" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">YEDEK PARÇA TEMİNİ ve MONTAJI</a>
                
                <p>İhtiyaca uygun yedek parçalar, güvenilir tedarikçilerden temin edilir ve montaj işlemi özenle gerçekleştirilir.</p>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="<?=RESIMLER?>masseyDonusum.jpg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">MASSEY FERGUSON 4X4 DÖNÜŞÜM</a>
                
                <p>Massey Ferguson Phantom 3000 serisi ve 200 serisi Traktörler için dönüşüm yapılmaktadır. </p>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="<?=RESIMLER?>chipTuning.jpg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">CHIP TUNING YAZILIM PERFORMANS ARTTIRMA</a>
                
                <p>Deutz-Fahr ve Same Traktörler için Chip Tuning yazılım ile  beygir arttırma ve yakıt tasarrufu  hizmeti vermekteyiz. </p>
            </div>
        </div>





















    </div>
</section>








<section class="contact" id="contact">
    <h1 class="heading"><span>İletişime</span> Geçin</h1>
    <div class="row">
        
        
        
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!3m2!1str!2str!4v1750180304816!5m2!1str!2str!6m8!1m7!1sFBFizJOrbStI8n5o2-lBHQ!2m2!1d39.7447133445112!2d39.49812194314494!3f265.0040987581187!4f-7.2544204630097795!5f0.7820865974627469" width="650" height="560" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        
        <form action="" method="post">
            <h3>İletişime Geç</h3>
            <div class="inputBox">
                <span class="fas fa-user"></span>
                <input type="text" name="name" placeholder="Ad-Soyad" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-envelope"></span>
                <input type="email" name="email" placeholder="E-Posta" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-phone"></span>
                <input type="tel" name="phone" placeholder="Telefon Numarası" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-comment"></span>
                <textarea name="mesaj" placeholder="Mesajınız" rows="2"></textarea>
            </div>
            <input type="submit" value="Şimdi iletişime geçin" class="btn">
        </form>
    </div>
</section>

<section class="footer">
    <h2 class="footer-title">TRUVA TRAKTÖR YETKİLİ SERVİS</h2>
    <div class="footer-info">
        <div class="contact">
            <h3>İletişim Bilgileri</h3>
            <p>Adres: Erzincan Merkez, Karaağaç Mah. 2. Oto Sanayi Sitesi 777 Sk. No: 18</p>
            <p>Yetkili Ad Soyad: Ahmet TEMEL</p>
            <p>📞 Telefon: <a href="tel:+905302522144">+90 530 252 21 44</a></p>
            <p>✉️ E-Posta: <a href="mailto:truvatraktoryetkiliservis@gmail.com">truvatraktoryetkiliservis@gmail.com</a></p>
            <p>✉️ E-Posta: <a href="<?=$_SESSION['email']?>">ahmettemel.erzincan@sdfservis.com</a></p>
        </div>
        <div class="hours">
            <h3>Çalışma Saatleri</h3>
            <p>Pazartesi - Salı - Çarşamba - Perşembe - Cuma - Cumartesi: 08:30 - 18:00</p>
            <p>Pazar: Kapalı</p>
        </div>
    </div>
    <div class="share">
        <a href="https://www.facebook.com/ahmet.temel.9047?mibextid=wwXIfr&rdid=fyzUntLGEOeuWP5o&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F19NNp271vs%2F%3Fmibextid%3DwwXIfr#" class="fab fa-facebook-f"></a>
        <a href="https://www.instagram.com/truva.traktor/" class="fab fa-instagram"></a>
    </div>
    <div class="links">
        <a href="#home">Anasayfa</a>
        <a href="#about">Hakkımızda</a>
        <a href="#services">Hizmetler</a>
        <a href="#contact">İletişim</a>
    </div>
    <div class="credit">TRUVA <span>TRAKTÖR</span> YETKİLİ SERVİS</div>
</section>

<script src="<?=JSLER?>script.js"></script>
</body>
</html>
