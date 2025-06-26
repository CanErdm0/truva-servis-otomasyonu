<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giriş Yap</title>
  <link rel="stylesheet" href="<?=CSSLER ?>giris_yap.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="<?=ANASAYFA?>baslik"></script>
  <link rel="icon" type="image/png" href="<?=RESIMLER?>logo2.png">
</head>
<body>
  <div class="wrapper"> 
    <form action="">
      <h1>GİRİŞ</h1> 


      <div class="input-box">
          <input type="email" name="email" id="email" placeholder="E-Posta" required>
          <i class="bx bxs-envelope"></i>
      </div>


      <div class="input-box">
            <input type="password" id="sifre" name="sifre" placeholder="Şifre" required>
            <i class='bx bxs-show toggle-eye' onclick="togglePassword('sifre', this)"></i> <!--  göz -->
            <i class='bx bxs-lock-alt'></i> <!--  kilit -->
        </div>


      <div class="remember-forgot">

        <label><input type="checkbox">Beni Hatırla</label>

        <a href="<?=ANASAYFA?>sifremiUnuttum">Şifremi Unuttum</a>
        
      </div>

        <button type="button" onclick="giris_yap(this)" class="btn">Giriş</button>

        <div class="register-link">
          <p>Hesabın yok mu? <a href="<?=ANASAYFA?>kaydol">Kaydol</a></p>
        </div>

    </form>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>
    <script src="<?=JSLER?>fonksiyonlar.js"></script>
  
</body>
</html>